<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function index(){
        return view('register', [
            'title' => 'Register',
        ]);
    }
    public function store(Request $request){
        $validasi = $request->validate([
            'name' => 'required',
            'username' => 'required | min:5 | max:100',
            'password' => 'required| min:6',
            'email' => 'required | email:dns'
        ]);

        $validasi['password'] = Hash::make($validasi['password']);
        User::create($validasi);
        return redirect('/login')->with('success', 'Registrasi Berhasil, Silahkan Login');
    }
}
