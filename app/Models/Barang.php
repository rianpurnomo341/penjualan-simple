<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $guarded = ['id_barang'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id_satuan');
    }
    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'suplier_id', 'id_suplier');
    }
}
