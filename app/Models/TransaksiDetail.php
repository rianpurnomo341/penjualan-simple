<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $table = 'divisi';
    protected $primaryKey = 'id_divisi';
    protected $guarded = ['id_divisi'];

    // public function id_instansi()
    // {
    //     return $this->belongsTo(Instansi::class, 'id_instansi', 'id_instansi');
    // }
}
