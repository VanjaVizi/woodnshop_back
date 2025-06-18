<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Narudzbina extends Model
{
     use HasFactory;

   protected $fillable = [
    'ime',
    'prezime',
    'email',
    'telefon',
    'adresa',
    'grad',
    'postanski_broj',
    'placanje',
    'napomena'
];


    public function stavke()
    {
        return $this->hasMany(StavkaNarudzbine::class);
    }
}
