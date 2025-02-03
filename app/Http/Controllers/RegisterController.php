<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('registration.index', [
            'title' => 'register',
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'username' => ['required', 'min:3', 'max:255', 'unique:users'],
                'email' => 'required|email:dns|unique:users',
                'password' => 'required|min:5|max:255',
                'unit_bagian' => 'required|in:dokter,perawat,it'
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);
            $validatedData['is_admin'] = true;

            $user = User::create($validatedData);

            if ($user) {
                return redirect('/login')->with('success', 'Registration successful! Please login.');
            }

            return back()->with('error', 'Registration failed. Please try again.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred during registration. Please try again.');
        }
    }
}
