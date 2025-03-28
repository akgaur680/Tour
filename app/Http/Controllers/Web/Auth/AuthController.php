<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showlogin()
    {
        return view('welcome');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        if (Auth::attempt($validated)) {
            if (Auth::user()) {
<<<<<<< HEAD
                return redirect('/dashboard/admin/index');
=======
                return redirect('/admin/dashboard');
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
            } 
            else{
                return redirect()->back()->withErrors(['login' => 'You are prohibited.']);
            }
        } else {
            return redirect()->back()->withErrors(['login' => 'Invalid credentials provided.'])->withInput();
        }
    }
<<<<<<< HEAD
=======

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
>>>>>>> 76edfe8a18cdd617ab98c5ee67bfdcc9bd4a60cd
}
