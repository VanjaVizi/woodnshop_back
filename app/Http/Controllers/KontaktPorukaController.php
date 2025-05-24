<?php

namespace App\Http\Controllers;

use App\Models\KontaktPoruka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class KontaktPorukaController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ime'    => 'required|string|max:255',
            'email'  => 'required|email',
            'poruka' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $poruka = KontaktPoruka::create($request->only('ime', 'email', 'poruka'));

        // 📩 Poruka korisniku
        Mail::raw("Poštovani {$poruka->ime},\n\nPrimili smo vašu poruku i uskoro ćemo vas kontaktirati.\n\nHvala na poverenju,\nWood'n'Shop tim", function ($message) use ($poruka) {
            $message->to($poruka->email)
                    ->subject('Vaša poruka je primljena');
        });

        // 📩 Poruka adminu
        $adminEmail = env('ADMIN_EMAIL');
        if ($adminEmail) {
            Mail::raw("Nova kontakt poruka od: {$poruka->ime}\nEmail: {$poruka->email}\nPoruka: {$poruka->poruka}", function ($message) use ($adminEmail) {
                $message->to($adminEmail)
                        ->subject('Stigla je nova kontakt poruka');
            });
        }

        return response()->json([
            'message' => 'Poruka uspešno poslata.',
            'data'    => $poruka
        ], 201);
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return KontaktPoruka::latest()->paginate($perPage);
    }
}
