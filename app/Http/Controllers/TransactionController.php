<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $userId = Auth::check() ? Auth::id() : null;
        $item = Item::find($request->input('item_id'));

        $transaction = new Transaction();
        $transaction->id_game = $request->input('id_game');
        $transaction->payment_id = $request->input('payment_id');
        $transaction->item_id = $request->input('item_id');
        $transaction->Wa_Number = $request->input('Wa_Number');
        $transaction->game_id = $request->input('game_id');
        $transaction->user_id = $userId;

        // Save data ke database, id_transaksi akan otomatis di-generate
        $transaction->save();
        $item->stock -= 1;
        $item->save();

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
                                                ->orWhere('status', 'Proses')->with('user')
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
                    'companies' => Company::all()
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
            'companies' => Company::all()
        ]);
    }
    public function revenue(){
        return view('admin.revenue', [
            'title' => 'Revenue',
            'transactions' => Transaction::where('status', 'Berhasil')->orWhere('status', 'Gagal')->get()
        ]);
    }
    public function transaksiadmin(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'status' => 'required|string'
        ]);

        // Cari transaksi
        $transaction = Transaction::find($id);

        // Cek jika tanggal saat ini sudah melewati created_at + 1 hari dan status masih "Menunggu Pembayaran"
        if ($transaction->status === 'Menunggu Pembayaran' && now()->greaterThan($transaction->created_at->addDay(1))) {
            // Ubah status menjadi gagal
            $transaction->status = 'Gagal';
            $transaction->save();
        }
        // Update status sesuai kondisi inputan
        if ($transaction->status === 'Menunggu Pembayaran' && $request->status === 'Konfirmasi Pembayaran') {
            $transaction->status = 'Proses';
        } elseif ($transaction->status === 'Proses' && $request->status === 'Selesaikan Proses') {
            $transaction->status = 'Berhasil';
        }

        $transaction->save();

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

}
