<?php
 
 
namespace App\Http\Controllers;

use App\Models\Narudzbina;
use App\Models\StavkaNarudzbine;
use Illuminate\Http\Request;

class NarudzbinaController extends Controller
{
    public function store(Request $request)
        {
            $data = $request->validate([
                'ime' => 'required|string|max:255',
                'prezime' => 'required|string|max:255',
                'email' => 'nullable|email',
                'telefon' => 'nullable|string|max:50',
                'adresa' => 'required|string|max:255',
                'grad' => 'required|string|max:255',
                'postanskiBroj' => 'required|string|max:20',
                'placanje' => 'required|in:pouzecem,racun',
                'napomena' => 'nullable|string',
                'stavke' => 'required|array|min:1',
                'stavke.*.proizvodId' => 'required|exists:proizvods,id',
                'stavke.*.naziv' => 'required|string',
                'stavke.*.dimenzija' => 'nullable|string',
                'stavke.*.cena' => 'nullable|numeric',
                'stavke.*.cenaNaUpit' => 'boolean',
                'stavke.*.kolicina' => 'required|integer|min:1',
                'stavke.*.napomenaKupca' => 'nullable|string',
            ]);

            // Ako koristiš camelCase u frontend payloadu
            $data['postanski_broj'] = $data['postanskiBroj'];

            $narudzbina = Narudzbina::create([
                'ime' => $data['ime'],
                'prezime' => $data['prezime'],
                'email' => $data['email'] ?? null,
                'telefon' => $data['telefon'] ?? null,
                'adresa' => $data['adresa'],
                'grad' => $data['grad'],
                'postanski_broj' => $data['postanski_broj'],
                'placanje' => $data['placanje'],
                'napomena' => $data['napomena'] ?? null,
            ]);

            foreach ($data['stavke'] as $stavka) {
                $narudzbina->stavke()->create([
                    'proizvod_id' => $stavka['proizvodId'],
                    'naziv_proizvoda' => $stavka['naziv'],
                    'dimenzija' => $stavka['dimenzija'] ?? null,
                    'cena' => $stavka['cena'],
                    'cena_na_upit' => $stavka['cenaNaUpit'] ?? false,
                    'kolicina' => $stavka['kolicina'],
                    'napomena_kupca' => $stavka['napomenaKupca'] ?? null,
                ]);
            }

            return response()->json(['message' => 'Narudžbina uspešno sačuvana!'], 201);
        }

}
