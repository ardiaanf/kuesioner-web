<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class elemen extends Model
{
    use HasFactory;

    protected $table = 'elemens';
    protected $primaryKey = 'id_elemen';
    public $timestamps = true;

    public function kuesioners() {
        return $this->belongsTo(kuesioner::class, 'id_kuesioner');
    }

    public function pertanyaans(){
        return $this->hasMany(pertanyaan::class, 'id_pertanyaan');
    }
}
