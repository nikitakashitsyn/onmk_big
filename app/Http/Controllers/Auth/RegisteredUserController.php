<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register', ['login' => User::getAvailableLogin()]);
    }

    public function createDoc()
    {
        return view('auth.register_doc');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, string $role)
    {

        if ($role === 'doc') {
            $request->validate([
                'name' => 'required|string|min:6',
                'password' => 'required|string|confirmed|min:6',
                'mail' => 'nullable|present|email:rfc,dns',
            ]);
            Auth::login($user = User::create([
                'login' => User::getAvailableLogin(),
                'email' => $request->mail,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'roles' => [User::ROLE_DOC],
            ]));
        } else {
            $request->validate([
                'login' => 'required|string|max:255|unique:users',
                'password' => 'required|string|confirmed|min:6',
                'mail' => 'nullable|present|email:rfc,dns',
            ]);
            Auth::login($user = User::create([
                'login' => $request->login,
                'password' => Hash::make($request->password),
            ]));
        }


        $user->passw = $request->password;
        $user->mail = $request->mail;

        event(new Registered($user));

        return redirect()->route('welcome');
    }
}
