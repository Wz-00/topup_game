<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
    $transaction = new Transaction();
    $transaction->id_game = $request->input('id_game');
    $transaction->payment_id = $request->input('payment_id');
    $transaction->item_id = $request->input('item_id');
    $transaction->Wa_Number = $request->input('Wa_Number');
    $transaction->game_id = $request->input('game_id');

    // Save data ke database, id_transaksi akan otomatis di-generate
    $transaction->save();

    // Redirect menggunakan id_transaksi
    return redirect()->route('nota', ['id_transaksi' => $transaction->id_transaksi]);
    }


    public function nota($id_transaksi = null)
    {
        // Pastikan user login
        if (Auth::check()) {
            $role = Auth::user()->role;
            
            // Jika role admin
            if ($role === 'admin') {
                return view('admin.transaksi', [
                    'title' => 'Transaksi',
                    'transactions' => Transaction::where('status', 'Menunggu Pembayaran')
                                                ->orWhere('status', 'Proses')
                                                ->get()
                ]);
            } 
            
            // Jika role bukan admin (user biasa), tampilkan transaksi berdasarkan id_transaksi
            else {
                // Cari transaksi berdasarkan id_transaksi
                $transaksi = Transaction::where('id_transaksi', $id_transaksi)->firstOrFail();

                return view('user.nota', [
                    'title' => 'Nota',
                    'transaksi' => $transaksi,
                    'metode' => $transaksi->payment,
                    'item' => $transaksi->item,
                ]);
            }
        } 
        
        // Jika tidak login, anggap sebagai user biasa
        else {
            $transaksi = Transaction::where('id_transaksi', $id_transaksi)->firstOrFail();

            return view('user.nota', [
                'title' => 'Nota',
                'transaksi' => $transaksi,
                'metode' => $transaksi->payment,
                'item' => $transaksi->item,
            ]);
        }
    }

    public function getNota(Request $request){
        $transaksi = null;
        // $id = $request->input('id');
        if ($request->has('search')) {
            $transaksi = Transaction::where('id_transaksi', request('search'))->first();
        }
        return view('user.search', [
            'title' => 'Cari Pesanan',
            'transaksi' => $transaksi,
            'metode' => optional($transaksi)->payment, 
            'item' => optional($transaksi)->item,
        ]);
    }
    public function revenue(){
        return view('admin.revenue', [
            'title' => 'Revenue',
            'transactions' => Transaction::where('status', 'Berhasil')->orWhere('status', 'Gagal')->get()
        ]);
    }
}
