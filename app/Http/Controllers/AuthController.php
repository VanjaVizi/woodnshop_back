<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // REGISTRACIJA
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Uspešno registrovan korisnik.',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    // LOGIN
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Pogrešan email ili lozinka.'], 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Uspešno ste se prijavili.',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Uspešno ste se odjavili.']);
    }

    // SLANJE LOZINKE NA MEJL (RESET BEZ IZMENE)
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Email adresa nije validna.'], 422);
        }

        $user = User::where('email', $request->email)->first();

        // Loša praksa u realnim aplikacijama — ali po zahtevu
        Mail::raw("Vaša lozinka je: {$user->password}", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Resetovanje lozinke');
        });

        return response()->json(['message' => 'Lozinka je poslata na vašu email adresu.']);
    }
}
