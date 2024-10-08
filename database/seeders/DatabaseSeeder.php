<?php

namespace Database\Seeders;

use App\Models\Game;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Item;
use App\Models\User;
use App\Models\Banner;
use App\Models\Company;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // \App\Models\User::factory(10)=>create();
        $users = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@mail.co',
                'role' => 'admin',
                'password' => bcrypt('admin123')
            ],
            [
                'name' => 'wildan',
                'username' => 'wizzsendpai',
                'email' => 'wildanjk14@gmail.com',
                'role' => 'member',
                'password' => bcrypt('idontknow'),
            ]
        ];
        User::insert($users);
        $games = [
            [
            'game' => 'Valorant',
            'slug' => 'valorant',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Debitis, doloribus cumque? Fugit quaerat molestias aliquam accusantium esse voluptatum quae et deleniti eaque, soluta ea veniam exercitationem nostrum, nam, libero eveniet recusandae. Vitae quis iure commodi est ad, soluta explicabo laudantium et alias distinctio sapiente veritatis asperiores. Soluta tenetur fugit ullam itaque id quaerat, quis eos, placeat sint nobis consectetur perferendis aliquid iusto dolores magnam pariatur nesciunt nemo quisquam. Ipsa hic, cupiditate sunt atque praesentium quasi sequi beatae modi deleniti ipsam impedit sit, maxime aliquid cumque dignissimos amet assumenda quo!',
            'image' => 'asset/img/game/valorant1.jpg'
            ],
            [
                'game' => 'PUBG Mobile',
                'slug' => 'pubg-mobile',
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Debitis, doloribus cumque? Fugit quaerat molestias aliquam accusantium esse voluptatum quae et deleniti eaque, soluta ea veniam exercitationem nostrum, nam, libero eveniet recusandae. Vitae quis iure commodi est ad, soluta explicabo laudantium et alias distinctio sapiente veritatis asperiores. Soluta tenetur fugit ullam itaque id quaerat, quis eos, placeat sint nobis consectetur perferendis aliquid iusto dolores magnam pariatur nesciunt nemo quisquam. Ipsa hic, cupiditate sunt atque praesentium quasi sequi beatae modi deleniti ipsam impedit sit, maxime aliquid cumque dignissimos amet assumenda quo!',
                'image' => 'asset/img/game/pubg-bg.jpg'],
            [
                'game' => 'Mobile Legends', 
                'slug' => 'mobile-legends',
                'description' => 'Cara Top Up<br>. Masukkan User ID dan Zone ID Anda, Contoh : 1234567 (1234) <br>. Pilih Nominal Diamonds yang kamu inginkan<br>. Selesaikan pembayaran <br>. Diamonds akan ditambahkan ke akun Mobile Legends kamu <br>', 
                'image' => 'asset/img/game/ml-bg.jpg'],
            [
                'game' => 'Genshin Impact',
                'slug' => 'genshin-impact',
                'description' => 'Cara Top Up <br>. Masukkan User ID dan Pilih Server Anda <br>. Pilih Nominal Crystals yang kamu inginkan <br>. Selesaikan pembayaran <br>. Crystals akan ditambahkan ke akun Genshin Impact kamu', 
                'image' => 'asset/img/game/genshin-bg.jpg'
            ],
            [
                'game' =>'League of Legends', 
                'slug' => 'lol',
                'description' => 'Cara Top Up <br>. Masukkan Riot ID Anda, Contoh : Lapakgaming#1234 <br>. Pilih Nominal Points yang kamu inginkan <br>. Selesaikan pembayaran <br>. Points akan ditambahkan ke akun League Of Legends kamu', 
                'image' => 'asset/img/game/lol-bg.jpg'
            ]
        ];
        
        Game::insert($games);
        
        $items = [
            [
                'item' => '357 VP', 'game_id' => 1, 'price' =>  41000, 'icon' =>'asset/img/icon/vp-icon.png'
            ],
            [
                'item' => '650 VP', 'game_id' => 1, 'price' => 68000, 'icon' =>'asset/img/icon/vp-icon.png'
            ],
            [
                'item' => '1350 VP', 'game_id' => 1, 'price' => 135000, 'icon' =>'asset/img/icon/vp-icon.png'
            ],
            [
                'item' => '2100 VP', 'game_id' => 1, 'price' => 198000, 'icon' =>'asset/img/icon/vp-icon.png'
            ],
            [
                'item' => '3600 VP', 'game_id' => 1, 'price' => 324500, 'icon' =>'asset/img/icon/vp-icon.png'
            ],
            [
                'item' => '7500 VP', 'game_id' => 1, 'price' => 666000, 'icon' =>'asset/img/icon/vp-icon.png'
            ],
            [
                'item' => '325 UC', 'game_id' => 2, 'price' => 80000, 'icon' => 'asset/img/icon/PUBG_UC.png'
            ],
            [
                'item' => '660 UC', 'game_id' => 2, 'price' => 158000, 'icon' => 'asset/img/icon/PUBG_UC.png'
            ],
            [
                'item' => '1800 UC', 'game_id' => 2, 'price' => 395000, 'icon' => 'asset/img/icon/PUBG_UC.png'
            ],
            [
                'item' => '3850 UC', 'game_id' => 2, 'price' => 790000, 'icon' => 'asset/img/icon/PUBG_UC.png' 
            ],
            [
                'item' => '170 Diamonds', 'game_id' => 3, 'price' => 43700, 'icon' => 'asset/img/icon/MLBB_Diamonds.png'
            ],
            [
                'item' => '240 Diamonds', 'game_id' => 3, 'price' => 62000, 'icon' => 'asset/img/icon/MLBB_Diamonds.png'
            ],
            [
                'item' => '296 Diamonds', 'game_id' => 3, 'price' => 76000, 'icon' => 'asset/img/icon/MLBB_Diamonds.png'
            ],
            [
                'item' => '408 Diamonds', 'game_id' => 3, 'price' => 104500, 'icon' => 'asset/img/icon/MLBB_Diamonds.png'
            ],
            [
                'item' => '568 Diamonds', 'game_id' => 3, 'price' => 142500, 'icon' => 'asset/img/icon/MLBB_Diamonds.png'
            ],
            [
                'item' => '875 Diamonds', 'game_id' => 3, 'price' => 218500, 'icon' => 'asset/img/icon/MLBB_Diamonds.png'
            ],
            [ 
            'item' => '330 Crystals', 'game_id' => 4, 'price' => 73000, 'icon' => 'asset/img/icon/Genshin-Impact_Crystals.png'
            ],
            [ 
                'item' =>'1090 Crystals', 'game_id' => 4, 'price' =>  30000, 'icon' => 'asset/img/icon/Genshin-Impact_Crystals.png'
            ],
            [ 
                'item' =>'2240 Crystals', 'game_id' => 4, 'price' =>  40000, 'icon' => 'asset/img/icon/Genshin-Impact_Crystals.png'
            ],
            [ 
                'item' =>'3880 Crystals', 'game_id' => 4, 'price' =>  34000, 'icon' => 'asset/img/icon/Genshin-Impact_Crystals.png'
            ],
            [
                'item' => '150 RP', 'game_id' => 5, 'price' => 15200, 'icon' => 'asset/img/icon/LOL_RP.png'
            ],
            [
                'item' => '775 RP', 'game_id' => 5, 'price' => 75000, 'icon' => 'asset/img/icon/LOL_RP.png'
            ],
            [
                'item' => '1400 RP', 'game_id' => 5, 'price' => 132000, 'icon' => 'asset/img/icon/LOL_RP.png'
            ],
            [
            'item' => '2850 RP', 'game_id' => 5, 'price' => 265000, 'icon' => 'asset/img/icon/LOL_RP.png'
            ],
            [
                'item' => '5250 RP', 'game_id' => 5, 'price' => 474000, 'icon' => 'asset/img/icon/LOL_RP.png'
            ],
            [
            'item' => '10000 RP', 'game_id' => 5, 'price' => 854000, 'icon' => 'asset/img/icon/LOL_RP.png'
            ]
        ];
            
        Item::insert($items);
        $banners = [
            [
                'game_id' => 1,
                'banner' => 'asset/img/banner/promo5.jpg'
            ],
            [
                'game_id' => 3,
                'banner' => 'asset/img/banner/promo6.jpg'
            ],
            [
                'game_id' => 4,
                'banner' => 'asset/img/banner/promo7.jpg'
            ],
            
        ];
        Banner::insert($banners);
        $pay = ['method' => 'Your Coins', 'slug' => 'your-coins', 'logo' => 'asset/img/payment/coins.png'];
        Payment::insert($pay);
        $payments = [
            ['method' => 'BCA Virtual Account', 'slug' => 'bca-va', 'number' => 12345678, 'logo' => 'asset/img/payment/bca.png'],
            ['method' => 'BRI Virtual Account', 'slug' => 'bri-va', 'number' => 32145678, 'logo' => 'asset/img/payment/BRI.png'],
            ['method' => 'BNI Virtual Account', 'slug' => 'bni-va', 'number' => 12365478, 'logo' => 'asset/img/payment/bni.png'],
            ['method' => 'Dana', 'slug' => 'dana', 'number' => 12345687, 'logo' => 'asset/img/payment/dana.png'],
            ['method' => 'OVO', 'slug' => 'ovo', 'number' => 87654321, 'logo' => 'asset/img/payment/ovo.png'],
            
        ];
        Payment::insert($payments);
        $company = [ 
            'name' => 'Your Company', 
            'UserId' => 1, 
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio nihil eos, inventore optio quibusdam rerum natus praesentium quis',
            'logo' => 'asset/img/default-logo.png',
            'ig' => 'cyberlabsofficial',
            'fb' => 'cyberlabsofficial',
            'wa' => 6285723036868,
            'tiktok' => '@cyberlabsofficial',
            'email' => 'marketing@cyberlabs.co.id'
        ];
        Company::insert($company);
    }
}
