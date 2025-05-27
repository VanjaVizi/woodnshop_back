<?php
namespace App\Http\Controllers;

use App\Models\Proizvod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProizvodController extends Controller
{
    public function index()
    {
        return Proizvod::latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'naziv'     => 'required|string|max:255',
            'opis'      => 'required|string',
            'cena'      => 'required|numeric|min:0',
            'popust'    => 'nullable|integer|min:0|max:100',
            'kategorija'=> 'required|string|max:100',
            'slike'     => 'nullable|array',
            'slike.*'   => 'image|mimes:jpeg,png,jpg,webp',
            'napomena'  => 'nullable|string', 
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $putanjeSlika = [];

        if ($request->hasFile('slike')) {
            foreach ($request->file('slike') as $slika) {
                $path = $slika->store('proizvodi', 'public'); // storage/app/public/proizvodi
                $putanjeSlika[] = '/storage/' . $path;
            }
        }

        $proizvod = Proizvod::create([
            'naziv'      => $request->naziv,
            'opis'       => $request->opis,
            'cena'       => $request->cena,
            'popust'     => $request->popust ?? 0,
            'kategorija' => $request->kategorija,
            'napomena'   => $request->napomena,
            'slike'      => $putanjeSlika,
        ]);

        return response()->json($proizvod, 201);
    }

    public function show($id)
    {
        return Proizvod::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $proizvod = Proizvod::findOrFail($id);

        $data = $request->only('naziv', 'opis', 'cena', 'popust', 'kategorija', 'napomena');
        $putanjeSlika = $proizvod->slike ?? [];

        if ($request->hasFile('slike')) {
            foreach ($request->file('slike') as $slika) {
                $path = $slika->store('proizvodi', 'public');
                $putanjeSlika[] = '/storage/' . $path;
            }
        }

        $data['slike'] = $putanjeSlika;

        $proizvod->update($data);

        return response()->json($proizvod);
    }

    public function destroy($id)
    {
        $proizvod = Proizvod::findOrFail($id);

        // Opciono: obriši slike iz storage-a
        if ($proizvod->slike && is_array($proizvod->slike)) {
            foreach ($proizvod->slike as $slika) {
                $filePath = str_replace('/storage/', '', $slika);
                Storage::disk('public')->delete($filePath);
            }
        }

        $proizvod->delete();

        return response()->json(['message' => 'Obrisano']);
    }

    public function byCategory($kategorija)
    {
        $proizvodi = Proizvod::where('kategorija', $kategorija)->latest()->paginate(12);
        return response()->json($proizvodi);
    }
}
