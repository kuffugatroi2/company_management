<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\AuthenticationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view('admin.login.login');
    }

    public function login(AuthenticationRequest $request)
    {
        $input = $request->only(['email', 'password']);
        $data = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return redirect()->route('admin.home_page');
        } else {
            return redirect()->back()->with('error', 'Email hoặc Password sai!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return "Chưa làm chức năng quên mật khẩu";
    }
}
