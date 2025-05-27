<?php

namespace App\Http\Controllers;

use App\Models\KontaktPoruka;
use Illuminate\Http\Request;
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
