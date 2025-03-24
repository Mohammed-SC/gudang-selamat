<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use App\Exceptions\BatchNumberConflictException;

class BarangMasuk extends Model
{
    protected $fillable = [
        'tanggal_masuk',
        'barang_id',
        'jumlah',
        'no_batch',
        'tanggal_expired'
    ];

    protected $dates = [
        'tanggal_masuk',
        'tanggal_expired'
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_expired' => 'datetime'
    ];

    public function namaBarang(): BelongsTo
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

        static::creating(function ($barangMasuk) {
            $existingBarangKeluar = BarangKeluar::where('barang_id', $barangMasuk->barang_id)
                ->where('no_batch', $barangMasuk->no_batch)
                ->exists();

            if ($existingBarangKeluar) {
                throw new BatchNumberConflictException('Nomor batch ini sudah digunakan dalam transaksi barang keluar');
            }
        });

        static::created(function ($barangMasuk) {
            DB::transaction(function () use ($barangMasuk) {
                Stock::updateOrCreateStock(
                    $barangMasuk->barang_id,
                    $barangMasuk->no_batch,
                    $barangMasuk->jumlah,
                    $barangMasuk->tanggal_expired
                );
            });
        });

        static::deleting(function ($barangMasuk) {
            $existingBarangKeluar = BarangKeluar::where('barang_id', $barangMasuk->barang_id)
                ->where('no_batch', $barangMasuk->no_batch)
                ->exists();

            if ($existingBarangKeluar) {
                throw new BatchNumberConflictException('Tidak dapat menghapus barang masuk karena nomor batch sudah digunakan dalam transaksi barang keluar');
            }
        });
    }
}
