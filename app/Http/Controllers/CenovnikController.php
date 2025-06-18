<?php

namespace App\Http\Controllers; 
use App\Models\Cenovnik;
use App\Models\Proizvod;
use Illuminate\Http\Request;

class CenovnikController extends Controller
{
    public function index($proizvod_id)
    {
        return Cenovnik::where('proizvod_id', $proizvod_id)->get();
    }

    public function store(Request $request)
        {
            $data = $request->validate([
                'proizvod_id' => 'required|exists:proizvodi,id',
                'naziv' => 'required|string|max:255',
                'cena' => 'required|numeric|min:0',
                'apply_to_category' => 'nullable|boolean',
            ]);

            // Prvo kreiramo za odabrani proizvod
            $cenovnici = [];

            $applyToCategory = $data['apply_to_category'] ?? false;

            if ($applyToCategory) {
                $proizvod = Proizvod::findOrFail($data['proizvod_id']);
                $kategorijaId = $proizvod->kategorija_id;

                // Pronađi sve proizvode u toj kategoriji
                $proizvodiUKategoriji = Proizvod::where('kategorija_id', $kategorijaId)->get();

                foreach ($proizvodiUKategoriji as $p) {
                    $cenovnici[] = Cenovnik::create([
                        'proizvod_id' => $p->id,
                        'naziv' => $data['naziv'],
                        'cena' => $data['cena'],
                    ]);
                }

                return response()->json([
                    'message' => 'Cenovnik je primenjen na celu kategoriju.',
                    'data' => $cenovnici
                ], 201);
            }

            // Ako se ne primenjuje na kategoriju, kreiraj samo za jedan proizvod
            $cenovnik = Cenovnik::create([
                'proizvod_id' => $data['proizvod_id'],
                'naziv' => $data['naziv'],
                'cena' => $data['cena'],
            ]);

            return response()->json($cenovnik, 201);
        }

    public function update(Request $request, $id)
    {
        $cenovnik = Cenovnik::findOrFail($id);

        $data = $request->validate([
            'naziv' => 'sometimes|required|string|max:255',
            'cena' => 'sometimes|required|numeric|min:0',
        ]);

        $cenovnik->update($data);

        return response()->json($cenovnik);
    }

    public function destroy($id)
    {
        $cenovnik = Cenovnik::findOrFail($id);
        $cenovnik->delete();

        return response()->json(['message' => 'Cenovnik obrisan.']);
    }
}
