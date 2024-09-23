<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\Item;

class BannerController extends Controller
{
    public function index(){
        return view('admin.banner', [
            'title' => 'Promote Your Game',
            'banners' => Banner::all(),
            'items' => Item::all(),
            'games' => Game::all()
        ]);
    }
}
