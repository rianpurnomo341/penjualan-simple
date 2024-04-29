<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $guarded = ['id_pembelian'];

    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'suplier_id', 'id_suplier');
    }

    public function detail_pembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id', 'id_pembelian');
    }

    public function user_admin()
    {
        return $this->hasMany(User::class, 'id', 'user_admin')->select('id', 'name', 'username');
    }

}
