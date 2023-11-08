<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;

    protected $table = 'detail_pembelian';
    protected $primaryKey = 'id_detail_pembelian';
    protected $guarded = ['id_detail_pembelian'];
    

    public function barang()
    {
        return $this->hasMany(Barang::class, 'barang_id', 'id_barang');
    }
}
