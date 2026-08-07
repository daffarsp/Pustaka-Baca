<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        if (auth()->user()->isAdmin()) {
            return '/admin/dashboard';
        }
        return '/mahasiswa/dashboard';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        // Allow login dengan email atau NIM/NIP
        $loginField = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) 
            ? 'email' 
            : 'nim_nip';

        return [
            $loginField => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }
}