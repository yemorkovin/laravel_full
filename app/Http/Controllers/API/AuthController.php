<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.registration');
    }

    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $data = $request->only(['name', 'email', 'password']);

        $jsonFilePath = 'users.json'; 
        if (file_exists($jsonFilePath)) {
            $jsonData = json_decode(file_get_contents($jsonFilePath), true);
        } else {
            $jsonData = [];
        } 

        $jsonData[] = $data;

        file_put_contents($jsonFilePath, json_encode($jsonData, JSON_PRETTY_PRINT));
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_USER, // Роль по умолчанию
        ]);

        return redirect()->route('login.form')->with('success', 'Регистрация успешно завершена.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/')->with('success', 'Вы успешно вошли.');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Вы вышли из системы.');
    }
}
