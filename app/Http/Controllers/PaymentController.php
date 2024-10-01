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
        $newPayment = new Payment;
        $newPayment->Payment = $request->Payment;
        $newPayment->slug = Str::slug($request->Payment);
        $newPayment->description = $request->description;
        $newPayment->image = $request->file('image')->store('/asset/img/Payment');
        $newPayment->save();
        return redirect('/')->with('status', 'Payment has been added');
    }
    public function updateStatus(Request $request){
        $payment = Payment::find($request->payment_id);

        if ($payment) {
            // Update status di database
            $payment->status = $request->status;
            $payment->save();
    
            return response()->json(['message' => 'Payment status updated successfully!']);
        }
    
        return response()->json(['message' => 'Payment not found!'], 404);
    }
    public function update(Request $request, Payment $payment){
        // Update payment data
        $payment->method = $request->input('method');
        $payment->number = $request->input('number');
        
        // Handle payment image upload
        if ($request->file('preview_logo')) {
            Storage::delete($payment->logo);
            $payment->logo = $request->file('preview_logo')->store('/asset/img/payment');
        }
        $payment->save();
        return redirect('/payment');
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


}
