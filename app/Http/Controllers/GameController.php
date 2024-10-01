<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Item;
use App\Models\Banner;
use App\Models\Company;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return view('admin.home', [
                    'title' => 'Home',
                    "games" => Game::all() 
                ]);
            } else {
                return view('user.home', [
                    'title' => 'Home',
                    'games' => Game::all(),
                    'banners' => Banner::all(),
                    'companies' => Company::all()
                ]);
            }
        } else {
            return view('user.home', [
                'title' => 'Home',
                'games' => Game::all(),
                'banners' => Banner::all(),
                'companies' => Company::all()
            ]); 
        }
    }
    
    public function detail(Game $game){
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return view('admin.game', [
                    'title' => 'Detail Game',
                    'game' => $game,
                    'item' => $game->item
                ]);
            }
            else {
                return view('user.game', [
                    'title' => 'Transaksi',
                    'games' => $game,
                    'items' => $game->item,
                    'payments' => Payment::all(),
                    'companies' => Company::all()
                ]);
            }
        }
        else{
            return view('user.game', [
                'title' => 'Transaksi',
                'games' => $game,
                'items' => $game->item,
                'payments' => Payment::all(),
                'companies' => Company::all()
            ]);
        }
    }
    public function upload(Request $request){
        // $uploads = $request->all();
        // Game::create($uploads);
        $newgame = new Game;
        $newgame->game = $request->game;
        $newgame->slug = Str::slug($request->game);
        $newgame->description = $request->description;
        $newgame->image = $request->file('image')->store('/asset/img/game');
        $newgame->save();
        return redirect('/')->with('status', 'Game has been added');
    }

    public function edit(Game $game){
        return view('admin.editgame', [
            'title' => 'Edit',
            'game' => $game,
            'item' => $game->item
        ]);
    }
    public function update(Request $request, Game $game)
    {
        // Update game data
        $game->game = $request->input('game');
        $game->description = $request->input('description');
        
        // Handle game image upload
        if ($request->hasFile('game_image')) {
            Storage::delete($game->image);
            $game->image = $request->file('game_image')->store('/asset/img/game');
        }

        $game->save();

        // Insert or update items
        $itemNames = $request->input('item_name', []);
        $itemPrices = $request->input('item_price', []);
        $itemStocks = $request->input('item_stock', []); // Retrieve stock input
        $itemImages = $request->file('item_image', []);

        foreach ($itemNames as $index => $itemName) {
            if (isset($itemPrices[$index]) && isset($itemStocks[$index])) {
                $item = Item::updateOrCreate(
                    ['game_id' => $game->id, 'item' => $itemName], // Find by game_id and item name
                    [
                        'price' => $itemPrices[$index],
                        'stock' => $itemStocks[$index], // Save stock value
                    ]
                );

                // Handle item image upload only if a new image is uploaded
                if (isset($itemImages[$index])) {
                    // Delete old icon if it exists and is not default
                    if ($item->icon && $item->icon !== 'default-icon.png') {
                        Storage::delete($item->icon);
                    }
                    // Save new icon
                    $item->icon = $itemImages[$index]->store('/asset/img/items');
                } else {
                    // Do not change the icon if it's already set and no new icon is uploaded
                    $item->icon = $item->icon ?? 'default-icon.png';
                }

                $item->save();
            }
        }

        // Delete items based on IDs
        if ($request->has('delete_item_ids')) {
            $deleteItemIds = explode(',', $request->input('delete_item_ids'));
            Item::whereIn('id', $deleteItemIds)->delete();
        }

        return redirect()->route('backToGame', ['game' => $game->slug])->with('status', 'Game and items have been updated');
    }

}
