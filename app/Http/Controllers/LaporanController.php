<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NamaBarang;
use App\Models\Stock;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;

class LaporanController extends Controller
{
    public function laporanstock(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $query = NamaBarang::with(['jenisBarang', 'satuanBarang'])
            ->select('barangs.*')
            ->selectRaw('COALESCE(SUM(stocks.jumlah), 0) as stock')
            ->leftJoin('stocks', 'barangs.id', '=', 'stocks.barang_id')
            ->groupBy('barangs.id');
        
        if ($filter === 'minimum') {
            $query->having('stock', '<=', 10);
        }
        
        $barangs = $query->get();
        return view('laporan.laporan-stock', compact('barangs', 'filter'));
    }

    public function laporanbarangmasuk(Request $request)
    {
        $query = BarangMasuk::with('namaBarang')
            ->select('barang_masuks.*', 'barangs.nama_barang')
            ->join('barangs', 'barang_masuks.barang_id', '=', 'barangs.id');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('barang_masuks.tanggal_masuk', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $barangMasuks = $query->orderBy('barang_masuks.tanggal_masuk', 'desc')->get();
        return view('laporan.laporan-barang-masuk', compact('barangMasuks'));
    }

    public function laporanbarangkeluar(Request $request)
    {
        $query = BarangKeluar::with(['barang.satuanBarang', 'namaCabang'])
            ->select('barang_keluars.*', 'barangs.nama_barang', 'barangs.kode_barang', 'satuan_barangs.satuan')
            ->join('barangs', 'barang_keluars.barang_id', '=', 'barangs.id')
            ->leftJoin('satuan_barangs', 'barangs.satuan_id', '=', 'satuan_barangs.id');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('barang_keluars.tanggal_keluar', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $barangKeluars = $query->orderBy('barang_keluars.tanggal_keluar', 'desc')->get();
        return view('laporan.laporan-barang-keluar', compact('barangKeluars'));
    }
}