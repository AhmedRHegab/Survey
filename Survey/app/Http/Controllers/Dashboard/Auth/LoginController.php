<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\AuthLoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('dashboard.auth.login');
    }// End Login

    public function loginProcess(AuthLoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        $user = Auth::guard('users')->attempt($credentials);


        // If User Is Login
        if ($user) {
            return redirect()->intended('dashboard/index');
        } else {
            return back()->withErrors(__('auth.failed'));
        }

    }

}
