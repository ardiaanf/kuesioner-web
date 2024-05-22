<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class response_data extends Model
{
    use HasFactory;
    protected $table = 'response_datas';
    protected $primaryKey = 'id_responseData';
    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function pertanyaans()
    {
        return $this->belongsTo(pertanyaan::class, 'id_pertanyaan');
    }

    public function jawabans()
    {
        return $this->belongsTo(jawaban::class, 'id_jawaban');
    }
}
