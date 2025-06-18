<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StavkaNarudzbine extends Model
{
    use HasFactory;

    protected $table = 'stavke_narudzbine'; // <- dodaj ovo da Laravel zna tačno ime tabele

    protected $fillable = [
        'narudzbina_id',
        'proizvod_id',
        'cenovnik_id',
        'naziv_proizvoda',
        'dimenzija',
        'cena',
        'cena_na_upit',
        'kolicina',
        'napomena_kupca',
    ];

    public function narudzbina()
    {
        return $this->belongsTo(Narudzbina::class);
    }
}
