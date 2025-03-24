<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    protected $fillable = [
        'barang_id',
        'no_batch',
        'jumlah',
        'tanggal_expired'
    ];

    protected $casts = [
        'tanggal_expired' => 'date'
    ];

    public function namaBarang(): BelongsTo
    {
        return $this->belongsTo(NamaBarang::class, 'barang_id');
    }

    public static function updateOrCreateStock($barangId, $noBatch, $jumlah, $tanggalExpired)
    {
        return self::updateOrCreate(
            ['barang_id' => $barangId, 'no_batch' => $noBatch],
            [
                'jumlah' => $jumlah,
                'tanggal_expired' => $tanggalExpired
            ]
        );
    }

    public static function decreaseStock($barangId, $noBatch, $jumlah)
    {
        $stock = self::where('barang_id', $barangId)
            ->where('no_batch', $noBatch)
            ->first();

        if ($stock && $stock->jumlah >= $jumlah) {
            $stock->jumlah -= $jumlah;
            $stock->save();
            return true;
        }

        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($stock) {
            static::updateTotalStock($stock->barang_id);
        });

        static::deleted(function ($stock) {
            static::updateTotalStock($stock->barang_id);
        });
    }

    protected static function updateTotalStock($barangId)
    {
        $totalStock = self::where('barang_id', $barangId)->sum('jumlah');
        
        DB::table('barangs')
            ->where('id', $barangId)
            ->update(['stock' => $totalStock]);
    }
}