<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cenovnik extends Model
{
    use HasFactory;
     protected $fillable = ['proizvod_id', 'naziv', 'cena'];

    public function proizvod()
    {
        return $this->belongsTo(Proizvod::class);
    }
}
