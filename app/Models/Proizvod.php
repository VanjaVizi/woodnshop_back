<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proizvod extends Model
{
    use HasFactory;
     protected $fillable = [
        'naziv', 'opis', 'cena', 'popust', 'kategorija', 'slike', 'napomena',
    ];

    protected $casts = [
        'slike' => 'array',
    ];
}
