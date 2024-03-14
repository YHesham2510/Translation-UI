<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';



    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}