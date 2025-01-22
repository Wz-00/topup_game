<?php

namespace App\Providers;
use App\Models\Company;
use App\Models\Item;
use App\Models\Message;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->share('company', Company::first());
        View::composer(['partials.navbar', 'partials.sidebar'], function ($view) {
            // Dapatkan user yang sedang login
            $user = Auth::user();
            
            // Inisialisasi variabel $count
            $count = 0;
            $countMessage = 0;
    
            // Cek apakah user sudah login dan memiliki role
            if ($user) {
                // Jika role user adalah 'admin'
                if ($user->role === 'admin') {
                    // Hitung transaksi dengan status 'Menunggu Pembayaran' atau 'Proses' untuk admin
                    $count = Transaction::whereIn('status', ['Konfirmasi Pembayaran', 'Proses'])->count();
                    
                    // Hitung pesan 'unread' untuk admin
                    $countMessage = Message::where('status', 'unread')->count();
                    $view->with('countMessage', $countMessage);
                } 
                // Jika role user adalah 'user'
                else {
                    // Hitung transaksi 'Menunggu Pembayaran' khusus untuk user yang sedang login
                    $count = Transaction::where('user_id', $user->id)
                        ->where('status', 'Menunggu Pembayaran')
                        ->count();
                }
            }
    
            // Bagikan variabel 'count' ke view 'navbar'
            $view->with('countTransaction', $count);
        });
    }
}
