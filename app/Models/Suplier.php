<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    use HasFactory;

    protected $table = 'suplier';
    protected $primaryKey = 'id_suplier';
    protected $guarded = ['id_suplier'];

    public function id_barang()
    {
        return $this->hasMany(Barang::class, 'id_suplier', 'id_suplier');
    }
}
