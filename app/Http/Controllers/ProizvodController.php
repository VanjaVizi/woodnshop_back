<?php

namespace App\Http\Controllers;

use App\Models\Proizvod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Kategorija;

class ProizvodController extends Controller
{
    public function index()
    {
        return Proizvod::latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'naziv'        => 'required|string|max:255',
            'opis'         => 'required|string',
            'cena'         => 'required|numeric|min:0',
            'popust'       => 'nullable|integer|min:0|max:100',
            'kategorija_id'=> 'required|exists:kategorijas,id',
            'slike'        => 'nullable|array',
            'slike.*'      => 'image|mimes:jpeg,png,jpg,webp',
            'napomena'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kategorija = Kategorija::find($request->kategorija_id);
        $putanjeSlika = [];

        if ($request->hasFile('slike')) {
            foreach ($request->file('slike') as $slika) {
                $path = $slika->store('proizvodi', 'public');
                $putanjeSlika[] = '/storage/' . $path;
            }
        }

        $proizvod = Proizvod::create([
            'naziv'      => $request->naziv,
            'opis'       => $request->opis,
            'cena'       => $request->cena,
            'popust'     => $request->popust ?? 0,
            'kategorija' => $kategorija->naziv,
            'kategorija_id' => $request->kategorija_id, 
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

        $validator = Validator::make($request->all(), [
            'naziv'        => 'sometimes|required|string|max:255',
            'opis'         => 'sometimes|required|string',
            'cena'         => 'sometimes|required|numeric|min:0',
            'popust'       => 'nullable|integer|min:0|max:100',
            'kategorija_id'=> 'nullable|exists:kategorijas,id',
            'napomena'     => 'nullable|string',
            'slike'        => 'nullable|array',
            'slike.*'      => 'image|mimes:jpeg,png,jpg,webp',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->only('naziv', 'opis', 'cena', 'popust', 'napomena');

        if ($request->has('kategorija_id')) {
            $kategorija = Kategorija::find($request->kategorija_id);
            $data['kategorija'] = $kategorija->naziv;
        }

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


    public function showByNaziv($naziv)
        {
            $proizvod = Proizvod::where('naziv', urldecode($naziv))->first();

            if (!$proizvod) {
                return response()->json(['message' => 'Proizvod nije pronađen.'], 404);
            }

            return response()->json(['data' => $proizvod]);
        }

        public function deleteImage($id, $imageIndex)
            {
                $proizvod = Proizvod::findOrFail($id);

                $slike = $proizvod->slike ?? [];
                if (!isset($slike[$imageIndex])) {
                    return response()->json(['message' => 'Slika nije pronađena.'], 404);
                }

                // Obriši fajl sa diska ako je uploadovan
                $filePath = str_replace('/storage/', '', $slike[$imageIndex]);
                Storage::disk('public')->delete($filePath);

                // Ukloni iz niza i ažuriraj redosled
                array_splice($slike, $imageIndex, 1);

                $proizvod->slike = $slike;
                $proizvod->save();

                return response()->json(['slike' => $slike]);
            }

        public function reorderImages(Request $request, $id)
        {
            $proizvod = Proizvod::findOrFail($id);
            $newOrder = $request->input('slike'); // niz novih putanja slika
            if (!is_array($newOrder) || count($newOrder) !== count($proizvod->slike)) {
                return response()->json(['message' => 'Neispravan niz slika.'], 422);
            }
            $proizvod->slike = $newOrder;
            $proizvod->save();
            return response()->json(['slike' => $proizvod->slike]);
        }



}
