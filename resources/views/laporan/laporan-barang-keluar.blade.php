@extends('layouts.main')

@section('title', 'Laporan Barang Keluar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item">Laporan</li>
    <li class="breadcrumb-item active">Laporan Barang Keluar</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Barang Keluar</h3>
    </div>
    <div class="card-body">
            <form action="{{ route('laporan.barang-keluar') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="start_date" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="end_date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cabang</th>
                        <th>Tanggal Keluar</th>
                        <th>No Batch</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Keluar</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangKeluars as $index => $barangKeluar)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $barangKeluar->namaCabang->nama_cabang }}</td>
                        <td>{{ date('Y-m-d', strtotime($barangKeluar->created_at)) }}</td>
                        <td>{{ $barangKeluar->no_batch }}</td>
                        <td>{{ $barangKeluar->kode_barang }}</td>
                        <td>{{ $barangKeluar->nama_barang }}</td>
                        <td>{{ abs($barangKeluar->jumlah) }}</td>
                        <td>{{ $barangKeluar->satuan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3 d-flex gap-2">
                <button onclick="exportToExcel()" class="btn btn-success">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </button>
                <button onclick="printTable()" class="btn btn-primary">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        responsive: true,
        autoWidth: false
    });
});

function exportToExcel() {
    const table = document.getElementById('dataTable');
    const wb = XLSX.utils.table_to_book(table, { sheet: 'Laporan Barang Keluar' });
    XLSX.writeFile(wb, 'laporan-barang-keluar.xlsx');
}

function printTable() {
    window.print();
}
</script>

<style media="print">
    @page { size: landscape; }
    body * { visibility: hidden; }
    #dataTable, #dataTable * { visibility: visible; }
    #dataTable { position: absolute; left: 0; top: 0; }
</style>
@endpush

@endsection