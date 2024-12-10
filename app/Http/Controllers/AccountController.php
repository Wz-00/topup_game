<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index(){
        $company = Company::first();
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return view('admin.account', [
                    'title' => 'Account',
                    'company' => $company,
                ]);
            }
            else{
                return view('user.account', [
                    'title' => 'Account',
                    'user' => Auth::user(),
                ]);
            }
        }  
        return redirect('/')->with('error', 'Anda Tidak memiliki akses untuk halaman ini');  
    }

    public function updateCompany(Request $request)
    {
        // Temukan perusahaan yang akan di-update
        $company = Company::find(1);
        // Cek apakah form mengirimkan logo perusahaan
        if ($request->hasFile('preview_logo') || $request->has('name') || $request->has('description')) {
            // Validasi input logo
            $company->name = $request->input('name');
            $company->description = $request->input('description');
            if ($request->file('preview_logo')) {
                Storage::delete($company->logo);
                $company->logo = $request->file('preview_logo')->store('/asset/img');
            }
            $company->save();
            return redirect()->back()->with('success', 'Company social links updated successfully.');
        }

        // Cek apakah form mengirimkan link sosial media
        if ($request->has('ig') || $request->has('fb') || $request->has('tiktok') || $request->has('wa') || $request->has('email')) {
            // Validasi input link sosial media
            

            // Update link sosial media
            $company->ig = $request->input('ig');
            $company->fb = $request->input('fb');
            $company->tiktok = $request->input('tiktok');
            $company->wa = $request->input('wa');
            $company->email = $request->input('email');

            $company->save();

            // Refresh data di session
            session()->forget('company');
            session()->put('company', $company);

            return redirect()->back()->with('success', 'Company social links updated successfully.');
        }

        return redirect()->back()->with('error', 'No changes detected.');
    }
    public function updatePassword(Request $request){
        $user = Auth::user();
    
        // Cek apakah old password sesuai
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old Password doesn\'t match');
        }
    
        // Cek apakah new password dan confirmation password sesuai
        if ($request->new_password != $request->new_password_confirmation) {
            return back()->with('error', 'New Password & Confirmation Password doesn\'t match');
        }
    
        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
    
        return back()->with('success', 'Password updated successfully');
    }
    public function updateUserInfo(Request $request, $id){
        $user = User::find($id);
        if ($user) {
            
            if ($request->has('name') || $request->has('username') || $request->has(key: 'wa') || $request->hasFile('avatar')) {
                $request->validate([
                    'name' => 'required | string',
                    'username' => 'required | string',
                    'wa' => 'max:15'
                ]);
                $user->name = $request->input('name');
                $user->username = $request->input('username');
                $wa = $request->input('wa');
                // Jika nomor telepon diawali dengan 0, ganti dengan +62
                if (substr($wa, 0, 1) === '0') {
                    $wa = '+62' . substr($wa, 1);
                }
                $user->Wa = $wa;
                if ($request->file('avatar')) {
                    $oldIconPath = public_path($user->avatar); // Convert relative path to absolute
                    if ($user->avatar !== null) {
                        unlink($oldIconPath); // Use unlink to delete the old file
                    }
                    $user->avatar = $request->file('avatar')->store('/asset/img/avatar');
                }
                $user->save();
                return back()->with('success', 'Informasi Berhasil diupdate');
            }
            elseif ($request->has('old_password') || $request->has('new_password') || $request->has('new_password_confirmation')) {
                // Cek apakah old password sesuai
                if (!Hash::check($request->old_password, $user->password)) {
                    return back()->with('error', 'Password sebelumnya salah');
                }
            
                // Cek apakah new password dan confirmation password sesuai
                if ($request->new_password != $request->new_password_confirmation) {
                    return back()->with('error', 'New Password & Confirmation Password doesn\'t match');
                }
            
                // Update password
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
            
                return back()->with('success', 'Password updated successfully');
            }
        }
    }
    public function destroyUser($id){
        $user = User::find($id);
        if ($user){
            $user->delete();
            return redirect('/')->with('success', 'User berhasil dihapus!');
        }
        return back()->with('failed', 'User gagal dihapus!');
    }
}
