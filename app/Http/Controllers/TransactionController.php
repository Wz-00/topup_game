<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Company;
use App\Models\Transaction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input request
        $request->validate([
            'id_game' => 'required',
            'payment_id' => 'required',
            'item_id' => 'required',
        ]);

        $userId = Auth::check() ? Auth::id() : null;
        $item = Item::find($request->input('item_id'));
        $coin = $item->coins === null ? null : $item->coins;

        // Pengecekan ketersediaan coins jika menggunakan payment id 1
        if ($request->input('payment_id') == 1 && Auth::check()) {
            $userCoins = Auth::user()->coins;

            if ($userCoins < $item->price) {
                // Jika coins user tidak mencukupi, batalkan transaksi dengan pesan error
                return back()->withErrors(['error' => 'Koin Anda tidak mencukupi untuk membeli item ini.']);
            }

            // Jika coins mencukupi, kurangi coins user
            Auth::user()->coins -= $item->price;
            Auth::user()->save();
        }

        // Membuat transaksi baru
        $transaction = new Transaction();
        $transaction->id_game = $request->input('id_game');
        $transaction->payment_id = $request->input('payment_id');
        $price = $item->discount ? $item->price * (1 - $item->discount / 100) : $item->price;
        $transaction->price = $price;
        $transaction->item_id = $request->input('item_id');
        
        // Mengisi nomor WhatsApp berdasarkan kondisi user login atau input user
        if (Auth::check()) {
            if (Auth::user()->Wa !== null) {
                $wa = Auth::user()->Wa;
                $transaction->Wa_Number = $wa;
            } else {
                $transaction->Wa_Number = $request->input('Wa_Number');
            }
        } else {
            $request->validate(['Wa_Number' => 'required']);
            $transaction->Wa_Number = $request->input('Wa_Number');
        }

        // Mengisi game_id dan user_id
        $transaction->game_id = $request->input('game_id');
        $transaction->user_id = $userId;
        $transaction->coins = $coin;

        // Mengatur status transaksi berdasarkan payment_id
        if ($request->input('payment_id') == 1) {
            // Jika menggunakan coins (payment id 1), status menjadi "Proses"
            $transaction->status = 'Proses';
        } else {
            // Untuk payment method lainnya, status default tetap "Menunggu Pembayaran"
            $transaction->status = 'Menunggu Pembayaran';
        }

        // Simpan data transaksi ke database
        $transaction->save();

        // Kurangi stok item
        $item->stock -= 1;
        $item->save();

        // Redirect ke halaman nota dengan id_transaksi
        return redirect()->route('nota', ['id_transaksi' => $transaction->id_transaksi]);
    }

    public function nota($id_transaksi)
    {
        $transaksi = Transaction::where('id_transaksi', $id_transaksi)->firstOrFail();

        return view('user.nota', [
            'title' => 'Nota',
            'transaksi' => $transaksi,
            'metode' => $transaksi->payment,
            'item' => $transaksi->item,
        ]);
    }
    public function transaksi(){
        if (Auth::check()) {
            $user = Auth::id();
            $role = Auth::user()->role;
            // Jika role admin
            if ($role === 'admin') {
                return view('admin.transaksi', [
                    'title' => 'Transaksi',
                    'transactions' => Transaction::where('status', 'Konfirmasi Pembayaran')
                                                ->orWhere('status', 'Menunggu Pembayaran')
                                                ->orWhere('status', 'Proses')->with('user')
                                                ->get(),
                ]);
            }
            else {
                return view('user.transaksi', [
                    'title' => 'Transaksi',
                    'unpaid' => Transaction::where('user_id', Auth::user()->id)->where('status', 'Menunggu Pembayaran')->with(['game', 'payment', 'item'])->get(),
                    'transactions' => Transaction::where('user_id', Auth::user()->id)->with(['game', 'payment', 'item'])->get(),
                    'user' => User::find($user)
                ]);
            }
        }
        return redirect('/')->with('error', 'Anda Tidak memiliki akses untuk halaman ini');  
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
        $transactions = DB::table('transactions')
                ->select(
                    DB::raw("DATE_FORMAT(created_at, '%M') as month"),
                    DB::raw("SUM(price) as total_revenue")
                )
                ->where('created_at', '>=', Carbon::now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('created_at')
                ->get();

            // Pisahkan label dan data untuk Chart.js
            $labels = $transactions->pluck('month');
            $data = $transactions->pluck('total_revenue');
        return view('admin.revenue', [
            'title' => 'Revenue',
            'transactions' => Transaction::where('status', 'Berhasil')->orWhere('status', 'Gagal')->get(),
            "labels" => $labels,
            "data" => $data,
        ]);
    }
    public function bukti(Request $request, $id){
        // $request->validate([
        //     'bukti' => 'required|image|max:2048',
        // ]);
        
        $transaction = Transaction::find($id);
        // if ($request->hasFile('bukti')) {
        //      // Convert relative path to absolute
        //     if ($transaction->bukti === null) {
        //         $oldIconPath = public_path($transaction->bukti);
        //         Storage::delete($oldIconPath); // Use unlink to delete the old file
        //     }
        //     $transaction->bukti = $request->file('bukti')->store('/asset/img/transaction');
        //     $transaction->status = $request->status;
        //     $transaction->save();
        //     return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
        // }
        // return redirect()->back()->with('error', 'gagal menambahkan gambar.');

        if ($request->hasFile('bukti')) {
            $transaction->bukti = $request->file('bukti')->store('/asset/img/transaction');
            $transaction->status = $request->status;
            $transaction->save();
            return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
        } else {
            return 'File Missing';
        }
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
            return back()->with('error', 'Transaksi dengan id '. $transaction->id_transaksi . ' Tidak membayar');
        }
        // Update status sesuai kondisi inputan
        if ($transaction->status === 'Konfirmasi Pembayaran' && $request->status === 'Konfirmasi Pembayaran') {
            $transaction->status = 'Proses';
            $transaction->save();
            return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
        } elseif ($transaction->status === 'Proses' && $request->status === 'Proses') {
            $transaction->status = 'Berhasil';
            if ($transaction->user_id !== null) {
                $user = User::find($transaction->user_id);
                $user->coins += $transaction->coins;
                $user->save();
            }
            $transaction->save();
            return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
        }

       

        return redirect()->back()->with('error', 'Gagal memperbarui status.');
    }

    public function cancelTransaction(Request $request, $id){
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'status' => 'required|string'
        ]);
        $transaction = Transaction::find($id);
        $transaction->status = 'Bukti Tidak Sesuai';
        $transaction->save();
        return back()->with('error', 'Bukti transaksi dengan id '. $transaction->id_transaksi . ' Tidak sesuai');
    }
    
}
