<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ConfirmPasswordController extends Controller
{

    public function view()
    {
        return view('dashboard.auth.confirm-password');

    }// End View

    public function confirmPassword(Request  $request):RedirectResponse
    {
        if(!Hash::check($request->password, $request->user()->password)){

            return back()->withErrors([
                'password'  => ['The provided password does not match our records.']
            ]);
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended();

    }// End ConfirmPassword
}
