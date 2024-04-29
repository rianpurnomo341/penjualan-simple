<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    protected $guarded = ['id_laporan'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id_pembelian');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id_penjualan');
    }

    public function user_admin()
    {
        return $this->hasMany(User::class, 'id', 'user_admin')->select('id', 'name', 'username');
    }
}
