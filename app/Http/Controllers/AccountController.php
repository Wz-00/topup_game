<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function index(){
        return view('admin.account', [
            'title' => 'Account',
        ]);
    }

    public function updateCompany(Request $request, Company $company){
        
        $company->name = $request->input('name');
        $company->name = $request->input('description');
        if ($request->hasFile('preview_logo')) {
            Storage::delete($company->logo);
            $company->logo = $request->file('preview_logo')->store('/asset/img');
        }
        $company->save();
        return back()->with('status', 'Game and items have been updated');
    }

    public function updateMedsos(Request $request){

    }
}
