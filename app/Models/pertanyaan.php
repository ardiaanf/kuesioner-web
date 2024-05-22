<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pertanyaan extends Model
{
    use HasFactory;
    protected $table = 'pertanyaans';
    protected $primaryKey = 'id_pertanyaan';
    public $timestamps = true;

    public function elemen()
    {
        return $this->belongsTo(elemen::class, 'id_elemen');
    }

    public function jawaban()
    {
        return $this->hasMany(jawaban::class, 'id_pertanyaan');
    }

    public function response_datas()
    {
        return $this->hasMany(response_data::class, 'id_pertanyaan');
    }
}
