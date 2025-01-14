<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        return view('web.pages.login.index');
    }

    public function store(Request $request)
    {
//        dd($request->input('latitude'));
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

           $user = Auth::user();
//           $user->latitude = $request->input('latitude');
//           $user->longitude = $request->input('longitude');
           $user->save();

            return redirect()->route('home.index');        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
