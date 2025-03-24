@extends('layouts.main')

@section('title', 'Laporan Stock')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item">Laporan</li>
    <li class="breadcrumb-item active">Laporan Stock</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Stock Barang</h3>
        <div class="card-tools">
        <form action="" method="GET" class="d-flex align-items-center">
            <select name="filter" class="form-control mr-2" onchange="this.form.submit()">
                <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua Stock</option>
                <option value="minimum" {{ $filter == 'minimum' ? 'selected' : '' }}>Stock Minimum</option>
            </select>
        </form>
    </div>
</div>
<div class="card-body">
    <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Satuan</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $index => $barang)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->jenisBarang->jenis }}</td>
                        <td>{{ $barang->satuanBarang->satuan }}</td>
                        <td>{{ $barang->stock }}</td>
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
    const wb = XLSX.utils.table_to_book(table, { sheet: 'Laporan Stock' });
    XLSX.writeFile(wb, 'laporan-stock.xlsx');
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