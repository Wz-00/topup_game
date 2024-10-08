<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login', [
            'title' => 'login',
        ]);
    }
    public function store(Request $request){
        $credential = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credential)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->with('loginfailed', 'Login Failed');
    }

    public function logout(Request $request){
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
        return redirect('/')->with('error', 'Logout gimana bro? lu aja belum login');
    }
}
