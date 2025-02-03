<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function redirectTo(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Redirect success',
                'user' => Auth::user()
            ], 200);
        }

        return redirect()->intended('/dashboard');
    }
}
