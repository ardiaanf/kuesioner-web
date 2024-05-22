<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jawaban extends Model
{
    use HasFactory;
    protected $table = 'jawabans';
    protected $primaryKey = 'id_jawaban';
    public $timestamps = true;

    public function pertanyaans()
    {
        return $this->belongsTo(pertanyaan::class, 'id_pertanyaan');
    }

    public function response_datas()
    {
        return $this->hasMany(response_data::class, 'id_jawaban');
    }
}
