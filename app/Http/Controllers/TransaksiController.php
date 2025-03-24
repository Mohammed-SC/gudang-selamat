<?php

namespace App\Http\Controllers;


use App\Exceptions\BatchNumberConflictException;
use Illuminate\Http\Request;
use App\Models\NamaBarang;
use App\Models\BarangMasuk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\NamaCabang;
use App\Models\BarangKeluar;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Stock;

class TransaksiController extends Controller
{
    public function barangMasuk()
    {
        $barangs = NamaBarang::all();
        $transaksi = BarangMasuk::with('namaBarang')->orderBy('created_at', 'desc')->get();
        return view('transaksi.barang-masuk', compact('barangs', 'transaksi'));
    }

    public function tambahBarangMasuk(Request $request)
    {
        try {
            $request->validate([
                'barang_id' => 'required|exists:barangs,id',
                'jumlah' => 'required|integer|min:1',
                'no_batch' => 'required|string',
                'tanggal_expired' => 'required|date|after:today',
            ]);
            
            DB::transaction(function () use ($request) {
                // Create barang masuk record
                BarangMasuk::create([
                    'tanggal_masuk' => Carbon::now(),
                    'barang_id' => $request->barang_id,
                    'jumlah' => $request->jumlah,
                    'no_batch' => $request->no_batch,
                    'tanggal_expired' => $request->tanggal_expired,
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Data barang masuk berhasil ditambahkan'
            ]);
        } catch (BatchNumberConflictException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ], 500);
        }
    }

    public function deleteBarangMasuk($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $barangMasuk = BarangMasuk::findOrFail($id);
                $stock = Stock::where('barang_id', $barangMasuk->barang_id)
                    ->where('no_batch', $barangMasuk->no_batch)
                    ->first();

                if ($stock) {
                    $stock->jumlah -= $barangMasuk->jumlah;
                    if ($stock->jumlah <= 0) {
                        $stock->delete();
                    } else {
                        $stock->save();
                    }
                }

                $barangMasuk->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Data barang masuk berhasil dihapus'
            ]);
        } catch (BatchNumberConflictException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 409);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data'
            ], 500);
        }
    }

    // Barang Keluar
    public function barangKeluar()
    {
        $cabang = NamaCabang::all();
        $barang = NamaBarang::with('satuanBarang')->get();
        $transaksi = BarangKeluar::with(['namaCabang', 'namaBarang'])->orderBy('created_at', 'desc')->get();
        return view('transaksi.barang-keluar', compact('cabang', 'barang', 'transaksi'));
    }

    public function getStock($barang_id)
    {
        $stocks = Stock::where('nama_barang_id', $barang_id)
            ->where('jumlah', '>', 0)
            ->orderBy('tanggal_expired')
            ->get();

        $totalStock = $stocks->sum('jumlah');

        $batchData = $stocks->map(function ($item) {
            return [
                'no_batch' => $item->no_batch,
                'tanggal_expired' => $item->tanggal_expired,
                'stock' => $item->jumlah
            ];
        });

        return response()->json([
            'batch_data' => $batchData,
            'stock' => $totalStock
        ]);
    }

    public function tambahBarangKeluar(Request $request)
    {
        $request->validate([
            'id_pengiriman' =>'required|string',
            'nama_cabang_id' => 'required|exists:nama_cabangs,id',
            'tanggal_keluar' => 'required|date',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $stock = Stock::where('barang_id', $request->barang_id)
            ->where('no_batch', $request->no_batch)
            ->first();

        if (!$stock || $stock->jumlah < $request->jumlah) {
            return redirect()->back()->with('error', 'Stock tidak mencukupi');
        }

        $cabang = NamaCabang::find($request->nama_cabang_id);
        // $lastId = BarangKeluar::where('nama_cabang_id', $request->nama_cabang_id)->count();
        // $idPengiriman = $cabang->kode_cabang . sprintf("%03d", $lastId + 1);
        $idPengiriman = $request->id_pengiriman;

        DB::transaction(function () use ($request, $idPengiriman) {
            BarangKeluar::create([
                'id_pengiriman' => $idPengiriman,
                'nama_cabang_id' => $request->nama_cabang_id,
                'tanggal_keluar' => $request->tanggal_keluar,
                'barang_id' => $request->barang_id,
                'jumlah' => $request->jumlah,
                'no_batch' => $request->no_batch,
                'tanggal_expired' => $request->tanggal_expired,
            ]);
        });

        return redirect()->back()->with('success', 'Data barang keluar berhasil ditambahkan');
    }

    public function deleteBarangKeluar($id)
    {
        DB::transaction(function () use ($id) {
            $barangKeluar = BarangKeluar::findOrFail($id);
            $stock = Stock::where('barang_id', $barangKeluar->barang_id)
                ->where('no_batch', $barangKeluar->no_batch)
                ->first();

            if ($stock) {
                $stock->jumlah += $barangKeluar->jumlah;
                $stock->save();
            } else {
                Stock::create([
                    'barang_id' => $barangKeluar->barang_id,
                    'no_batch' => $barangKeluar->no_batch,
                    'jumlah' => $barangKeluar->jumlah,
                    'tanggal_expired' => $barangKeluar->tanggal_expired
                ]);
            }

            $barangKeluar->delete();
        });

        return redirect()->back()->with('success', 'Data barang keluar berhasil dihapus');
    }

    public function getBarangMasukData($id)
    {
        try {
            $stocks = Stock::where('barang_id', $id)
                ->where('jumlah', '>', 0)
                ->orderBy('tanggal_expired')
                ->get();

            $batchData = $stocks->map(function ($item) {
                return [
                    'no_batch' => $item->no_batch,
                    'tanggal_expired' => $item->tanggal_expired,
                    'stock' => $item->jumlah
                ];
            });

            return response()->json([
                'batch_data' => $batchData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error loading batch numbers: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getLastId($cabang_id)
    {
        $cabang = NamaCabang::find($cabang_id);
        $tanggal = request('tanggal');

        $lastShipmentSameDate = BarangKeluar::where('nama_cabang_id', $cabang_id)
            ->whereDate('tanggal_keluar', $tanggal)
            ->first();

        if ($lastShipmentSameDate) {
            return response()->json(['id_pengiriman' => $lastShipmentSameDate->id_pengiriman]);
        }

        $lastId = BarangKeluar::where('nama_cabang_id', $cabang_id)
            ->orderBy('id', 'desc')
            ->first();

        $nextId = $lastId ? (int)substr($lastId->id_pengiriman, -3) + 1 : 1;
        $idPengiriman = $cabang->kode_cabang . sprintf("%03d", $nextId);

        return response()->json(['id_pengiriman' => $idPengiriman]);
    }

    public function exportBarangKeluar()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Pengiriman');
        $sheet->setCellValue('C1', 'Cabang');
        $sheet->setCellValue('D1', 'Tanggal Keluar');
        $sheet->setCellValue('E1', 'Nama Barang');
        $sheet->setCellValue('F1', 'Jumlah');
        $sheet->setCellValue('G1', 'No. Batch');
        $sheet->setCellValue('H1', 'Expired');

        $transaksi = BarangKeluar::with(['namaCabang', 'namaBarang'])->get();
        $row = 2;
        foreach ($transaksi as $index => $item) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $item->id_pengiriman);
            $sheet->setCellValue('C' . $row, $item->namaCabang->nama_cabang);
            $sheet->setCellValue('D' . $row, $item->tanggal_keluar->format('Y-m-d'));
            $sheet->setCellValue('E' . $row, $item->namaBarang->nama_barang);
            $sheet->setCellValue('F' . $row, $item->jumlah);
            $sheet->setCellValue('G' . $row, $item->no_batch);
            $sheet->setCellValue('H' . $row, $item->tanggal_expired->format('Y-m-d'));
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'barang-keluar-' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}