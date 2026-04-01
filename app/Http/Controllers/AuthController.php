<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $request->session()->regenerate();
            
            $guard = $user->role === 'admin' ? 'admin' : 'web';
            Auth::guard($guard)->login($user);

            return $this->redirectByRole($user->role);
        }

        return back()->withErrors(['email' => 'Invalid email or password']);
    }

    private function getGuardByRole($role)
    {
        return $role === 'admin' ? 'admin' : 'web';
    }

    private function redirectByRole($role)
    {
        return $role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->intended('/');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'student'
        ]);

        Auth::guard('web')->login($user);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $guard = $this->getGuardByRole($user->role);
            Auth::guard($guard)->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}
