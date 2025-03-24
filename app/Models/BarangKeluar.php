<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class BarangKeluar extends Model
{
    protected $fillable = [
        'id_pengiriman',
        'nama_cabang_id',
        'tanggal_keluar',
        'barang_id',
        'jumlah',
        'no_batch',
        'tanggal_expired'
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
        'tanggal_expired' => 'date'
    ];

    public function namaCabang(): BelongsTo
    {
        return $this->belongsTo(NamaCabang::class);
    }

    public function namaBarang(): BelongsTo
    {
        return $this->belongsTo(NamaBarang::class, 'barang_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(NamaBarang::class, 'barang_id');
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, ['barang_id', 'no_batch'], ['barang_id', 'no_batch']);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($barangKeluar) {
            DB::transaction(function () use ($barangKeluar) {
                $success = Stock::decreaseStock(
                    $barangKeluar->barang_id,
                    $barangKeluar->no_batch,
                    $barangKeluar->jumlah
                );

                if (!$success) {
                    throw new \Exception('Stok tidak mencukupi');
                }
            });
        });
    }
}
