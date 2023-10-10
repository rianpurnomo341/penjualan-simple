<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $guarded = ['id_transaksi'];

    // public function id_instansi()
    // {
    //     return $this->belongsTo(Instansi::class, 'id_instansi', 'id_instansi');
    // }
}
