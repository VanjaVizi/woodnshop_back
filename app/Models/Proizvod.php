<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proizvod extends Model
{
    use HasFactory;
     protected $fillable = [
        'naziv', 'opis', 'cena', 'popust', 'kategorija', 'slike', 'napomena', 'kategorija_id'
    ];

    protected $casts = [
        'slike' => 'array',
    ];


    public function cenovnici()
        {
            return $this->hasMany(Cenovnik::class);
        }

        public function kategorijaObjekat()
        {
            return $this->belongsTo(Kategorija::class, 'kategorija_id');
        }
}
