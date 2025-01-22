<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(){
        return view('admin.payment', [
            'title' => 'Payment',
            'payments' => Payment::all()
        ]);
    }
    public function edit(Payment $payment){
        return view('admin.editPayment', [
            'title' => 'Edit Payment',
            'payments' =>$payment
        ]);
    }
    public function upload(Request $request){
        $request->validate([
            'method' => 'required',
            'rekening' => 'required | max:11',
            'logo' => 'required | image | max:2048',
        ]);
        $newPayment = new Payment;
        $newPayment->method = $request->input('method');
        $newPayment->slug = Str::slug($request->input('method'));
        $newPayment->number = $request->input('rekening');
        $newPayment->logo = $request->file('logo')->store('/asset/img/Payment');
        $newPayment->save();
        return redirect('/payment')->with('success', 'Payment has been added');
    }
    public function updateStatus(Request $request){
        $payment = Payment::find($request->payment_id);

        if ($payment) {
            // Update status di database
            $payment->status = $request->status;
            $payment->save();
    
            return back()->with(['success' => 'Payment status updated successfully!']);
        }
    
        return redirect()->back()->with(['error' => 'Payment not found!'], 404);
    }
    public function update(Request $request, Payment $payment)
{
    $request->validate([
        'method' => 'required',
        'number' => 'required | digits_between:1,11 | integer ',
        'preview_logo' => 'nullable | image | max:2048',
    ]);
    if ($payment) {
        // Update payment data
        $payment->method = $request->input('method');
        $payment->number = $request->input('number');
        $payment->slug = Str::slug($request->input('method'));

        // Handle payment image upload
        if ($request->file('preview_logo')) {
            // Hapus gambar lama hanya jika logo tidak null atau kosong
            if ($payment->logo) {
                Storage::delete($payment->logo);
            }
            // Simpan gambar baru
            $payment->logo = $request->file('preview_logo')->store('/asset/img/payment');
        }

        $payment->save();

        return redirect('/payment')->with('success', 'Payment Update successfully!');
    }

    return redirect('/payment')->with('error', 'Gagal update!');
}

    public function destroy($id)
    {
        $payment = Payment::find($id);

        if ($payment) {
            // Hapus payment dari database
            $payment->delete();

            return redirect()->back()->with('success', 'Payment deleted successfully!');
        }

        return redirect()->back()->with('error', 'Payment not found!');
    }
    public function setDiscount(Request $request, $id)
    {
        $item = Item::find($id);

        if ($item) {
            // Validasi nilai diskon
            $request->validate([
                'discount' => 'required|integer|min:0|max:100',
            ]);

            // Set diskon
            $item->discount = $request->input('discount');
            $item->save();

            return redirect()->back()->with('success', 'Discount set successfully!');
        }

        return redirect()->back()->with('error', 'Item not found!');
    }

    public function removeDiscount(Request $request, $id)
    {
        $item = Item::find($id);

        if ($item) {
            // Hapus diskon
            $item->discount = null;
            $item->save();

            return redirect()->back()->with('success', 'Discount removed successfully!');
        }

        return redirect()->back()->with('error', 'Item not found!');
    }
    public function setCoins(Request $request, $id){
        $item = Item::find($id);

        if ($item) {
            // Validasi nilai diskon
            $request->validate([
                'coins' => 'required|integer|min:0|max:1000',
            ]);

            // Set diskon
            $item->coins = $request->input('coins');
            $item->save();

            return redirect()->back()->with('success', 'Coins set successfully!');
        }

        return redirect()->back()->with('error', 'Item not found!');
    }
    public function removeCoins($id){
        $item = Item::find($id);

        if ($item) {
            // Hapus diskon
            $item->coins = null;
            $item->save();

            return redirect()->back()->with('success', 'Coins removed successfully!');
        }

        return redirect()->back()->with('error', 'Item not found!');
    }
}
