<?php

namespace App\Http\Controllers;

use App\Helpers\HttpHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminViewController extends Controller
{
    public function login() {
        return view('login');
    }

    public function get(AdminLoginRequest $request) {
        return view('admin');
    }
}
