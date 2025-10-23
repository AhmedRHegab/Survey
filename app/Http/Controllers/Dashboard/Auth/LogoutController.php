<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    // Destroy The Session

    public function logout(Request $request) {

        Auth::guard('users')->logout();

        return redirect('dashboard/login');
    }
}
