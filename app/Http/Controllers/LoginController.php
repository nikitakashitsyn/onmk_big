<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials) || Auth::attempt(['email' => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user && $user->hasRole(User::ROLE_ADMIN)) {
                return redirect()->intended(route('admin'));
            }
            if ($user && $user->hasRole(User::ROLE_DOC)) {
                return redirect()->intended(route('patients_list'));
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Введен неверный логин или пароль',
        ]);
    }
}
