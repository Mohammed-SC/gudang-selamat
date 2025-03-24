<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NamaBarang extends Model
{
    protected $table = 'barangs';
    protected $fillable = ['kode_barang', 'nama_barang', 'jenis_barang', 'satuan_id'];

    public function satuanBarang()
    {
        return $this->belongsTo(SatuanBarang::class, 'satuan_id');
    }

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang', 'jenis');
    }
}
