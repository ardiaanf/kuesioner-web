<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginAdminController extends Controller
{
    public function showLoginForm() {
        return view('auth.loginadmin');
    }

}
