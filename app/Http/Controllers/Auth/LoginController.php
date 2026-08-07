<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // Override redirect setelah login
    protected function redirectTo()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return '/admin/dashboard';
            } else {
                return '/mahasiswa/dashboard';
            }
        }
        return '/login';
    }

    // Allow login dengan email atau NIM/NIP
    public function username()
    {
        $login = request()->input('email');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim_nip';
        request()->merge([$field => $login]);
        return $field;
    }
}