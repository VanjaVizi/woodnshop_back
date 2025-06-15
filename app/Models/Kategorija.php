<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
   use HasFactory;

    protected $fillable = [
        'slug',
        'naziv',
        'opis',
    ];

    public function proizvodi()
    {
        return $this->hasMany(Proizvod::class, 'kategorija_id');
    }

}
