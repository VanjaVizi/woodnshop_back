<?php

namespace App\Http\Controllers;

use App\Models\Kategorija;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategorijaController extends Controller
{
    // Vrati sve kategorije
    public function index()
    {
        return response()->json([
            'data' => Kategorija::orderBy('id')->get()
        ]);
    }

    // Vrati jednu kategoriju po slug-u
    public function showBySlug($slug)
    {
        $kategorija = Kategorija::where('slug', $slug)->first();

        if (!$kategorija) {
            return response()->json(['message' => 'Kategorija nije pronađena.'], 404);
        }

        return response()->json([
            'data' => $kategorija
        ]);
    }

    // Vrati kategoriju po ID-ju
    public function show($id)
    {
        $kategorija = Kategorija::find($id);

        if (!$kategorija) {
            return response()->json(['message' => 'Kategorija nije pronađena.'], 404);
        }

        return response()->json(['data' => $kategorija]);
    }

    // Dodaj novu kategoriju
    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'slug' => 'nullable|string|max:255|unique:kategorijas,slug',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['naziv']);

        $kategorija = Kategorija::create($validated);

        return response()->json(['data' => $kategorija], 201);
    }

    // Ažuriraj postojeću kategoriju
    public function update(Request $request, $id)
    {
        $kategorija = Kategorija::findOrFail($id);

        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'slug' => "nullable|string|max:255|unique:kategorijas,slug,{$id}",
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['naziv']);

        $kategorija->update($validated);

        return response()->json(['data' => $kategorija]);
    }

    // Obriši kategoriju
    public function destroy($id)
    {
        $kategorija = Kategorija::findOrFail($id);
        $kategorija->delete();

        return response()->json(['message' => 'Kategorija je uspešno obrisana.']);
    }
}
