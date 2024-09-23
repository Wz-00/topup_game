<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index(){
        return view('admin.payment', [
            'title' => 'Payment',
            'payments' => Payment::all()
        ]);
    }
}
