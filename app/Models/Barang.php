<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';
    protected $guarded = ['id_barang'];

    public function id_kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
    public function id_satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }
    public function id_suplier()
    {
        return $this->belongsTo(Suplier::class, 'id_suplier', 'id_suplier');
    }
}
