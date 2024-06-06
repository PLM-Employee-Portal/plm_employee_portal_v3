<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizeController extends Controller
{
    public function verify(Request $request)
    {
        
        $credentials = [
            'employee_id' => $request->input('id'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('home');
        } else {
            // Authentication failed...
            return back()->withErrors([
                'message' => 'The provided credentials do not match our records.',
            ]);
        }
    }
}
