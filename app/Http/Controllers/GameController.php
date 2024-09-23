<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Item;
use App\Models\Banner;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
                    'banners' => Banner::all()
                ]);
            }
        } else {
            return view('user.home', [
                'title' => 'Home',
                'games' => Game::all(),
                'banners' => Banner::all()
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
                ]);
            }
        }
        else{
            return view('user.game', [
                'title' => 'Transaksi',
                'games' => $game,
                'items' => $game->item,
                'payments' => Payment::all()
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
}
