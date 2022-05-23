<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' =>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'min:8|required|string'
        ]);

        $user = User::create([
            'name' =>$validatedData['name'],
            'email'=>$validatedData['email'],
            'password'=>Hash::make($validatedData['password']),
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json('El correo no ha sido verificado', 401);
        } else {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return response()->json(["user" => Auth::user()], 201);
            } else {
                return response()->json('Usuario o contraseña incorrecta', 401);
            }
        }
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json('El correo no ha sido verificado', 401);
        } else {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return response()->json(["user" => Auth::user()], 201);
            } else {
                return response()->json('Usuario o contraseña incorrecta', 401);
            }
        }
    }

    public function logout(Request $request)
    { //hace logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message'=>'Sesion cerrada'],200);
    }

}
