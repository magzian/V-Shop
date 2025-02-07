<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm(){
        return Inertia::render('Admin/Auth/Login');
    }

    public function login(Request $request){
        //Add your logic here
        //Check whether the user the user is adn admin and redirect apppropriately

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'isAdmin' => true])){
            return redirect()->route('admin.dashboard'); //Redirect to the main dashboard
        }

        return redirect()-> route('admin.login')->with('error', 'Invalid credentials.');
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        return redirect()->route('admin.login');
    }


}
