@extends('layouts.main')

@section('title', 'Barang Keluar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item">Transaksi</li>
    <li class="breadcrumb-item active">Barang Keluar</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Input Barang Keluar</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card-body">
        <form action="{{ url('/transaksi/barang-keluar/add') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Cabang</label>
                    <select name="nama_cabang_id" id="nama_cabang" class="form-control" required>
                        <option value="">Pilih Cabang</option>
                        @foreach($cabang as $c)
                            <option value="{{ $c->id }}">{{ $c->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>ID Pengiriman</label>
                    <input type="text" name="id_pengiriman" id="id_pengiriman" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Nama Barang</label>
                    <select name="barang_id" id="nama_barang" class="form-control" required disabled>
                        <option value="">Pilih Barang</option>
                        @foreach($barang as $b)
                            <option value="{{ $b->id }}" data-satuan="{{ $b->satuanBarang->nama_satuan }}">
                                {{ $b->nama_barang }} - {{ $b->kode_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>No. Batch</label>
                    <select name="no_batch" id="no_batch" class="form-control" required disabled>
                        <option value="">Pilih Nomor Batch</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Stock Tersedia</label>
                    <input type="text" id="stock" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Jumlah Keluar</label>
                    <div class="input-group">
                        <input type="number" name="jumlah" id="jumlah" class="form-control" required min="1" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">Sisa Stock: <span id="sisa_stock">0</span></span>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="tanggal_expired" id="tanggal_expired">

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Data Barang Keluar</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pengiriman</th>
                <th>Cabang</th>
                <th>Tanggal Keluar</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>No. Batch</th>
                <th>Expired</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->id_pengiriman }}</td>
                <td>{{ $item->namaCabang->nama_cabang }}</td>
                <td>{{ $item->tanggal_keluar->format('Y-m-d') }}</td>
                <td>{{ $item->namaBarang->nama_barang }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->no_batch }}</td>
                <td>{{ $item->tanggal_expired->format('Y-m-d') }}</td>
                <td>
                    <form action="{{ url('/transaksi/barang-keluar/delete/'.$item->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => result.isConfirmed);"><i class="fas fa-trash me-1"></i>Delete</button>
                    </form>
                </td>
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

<style media="print">
    @page { size: landscape; }
    body * { visibility: hidden; }
    #dataTable, #dataTable * { visibility: visible; }
    #dataTable { position: absolute; left: 0; top: 0; }
    .no-print, .alert, .card { display: none !important; }
</style>

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

        function printTable() {
            window.print();
        }

        function exportToExcel() {
            const table = document.getElementById('dataTable');
            const wb = XLSX.utils.table_to_book(table, {sheet: 'Barang Keluar'});
            XLSX.writeFile(wb, 'barang-keluar.xlsx');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Event listeners for ID Pengiriman generation
            document.getElementById('nama_cabang').addEventListener('change', updateIdPengiriman);
            document.querySelector('input[name="tanggal_keluar"]').addEventListener('change', updateIdPengiriman);

            // Event listener for Nama Barang change
            document.getElementById('nama_barang').addEventListener('change', function() {
                const batchSelect = document.getElementById('no_batch');
                const stockInput = document.getElementById('stock');
                const jumlahInput = document.getElementById('jumlah');
                const sisaStockSpan = document.getElementById('sisa_stock');

                if (this.value) {
                    fetch(`/transaksi/get-barang-masuk/${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            batchSelect.innerHTML = '<option value="">Pilih No. Batch</option>';
                            if (data.batch_data && data.batch_data.length > 0) {
                                // Sort batch data by expiry date
                                const sortedBatches = data.batch_data
                                    .filter(batch => batch.stock > 0)
                                    .sort((a, b) => new Date(a.tanggal_expired) - new Date(b.tanggal_expired));

                                sortedBatches.forEach(batch => {
                                    const option = document.createElement('option');
                                    option.value = batch.no_batch;
                                    option.setAttribute('data-stock', batch.stock);
                                    option.setAttribute('data-expired', batch.tanggal_expired);
                                    const expiredDate = new Date(batch.tanggal_expired).toLocaleDateString();
                                    option.textContent = `${batch.no_batch} (Stock: ${batch.stock}, Expired: ${expiredDate})`;
                                    batchSelect.appendChild(option);
                                });
                                batchSelect.disabled = false;
                            } else {
                                batchSelect.innerHTML = '<option value="">Tidak ada batch tersedia</option>';
                                batchSelect.disabled = true;
                            }
                            stockInput.value = '';
                            sisaStockSpan.textContent = '0';
                            jumlahInput.value = '';
                            jumlahInput.disabled = true;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            batchSelect.innerHTML = '<option value="">Error loading batch numbers</option>';
                            batchSelect.disabled = true;
                            stockInput.value = '';
                            sisaStockSpan.textContent = '0';
                            jumlahInput.disabled = true;
                            jumlahInput.value = '';
                        });
                } else {
                    batchSelect.disabled = true;
                    batchSelect.innerHTML = '<option value="">Pilih No. Batch</option>';
                    stockInput.value = '';
                    sisaStockSpan.textContent = '0';
                    jumlahInput.disabled = true;
                    jumlahInput.value = '';
                }
            });

            // Event listener for No. Batch change
            document.getElementById('no_batch').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const jumlahInput = document.getElementById('jumlah');
                const stockInput = document.getElementById('stock');
                const sisaStockSpan = document.getElementById('sisa_stock');

                if (this.value) {
                    const stock = selectedOption.getAttribute('data-stock');
                    const expired = selectedOption.getAttribute('data-expired');
                    stockInput.value = stock;
                    sisaStockSpan.textContent = stock;
                    document.getElementById('tanggal_expired').value = expired;
                    jumlahInput.disabled = false;
                    jumlahInput.max = stock;
                } else {
                    stockInput.value = '';
                    sisaStockSpan.textContent = '0';
                    document.getElementById('tanggal_expired').value = '';
                    jumlahInput.disabled = true;
                    jumlahInput.value = '';
                }
            });

            // Event listener for Jumlah input
            document.getElementById('jumlah').addEventListener('input', function() {
                const stockValue = parseInt(document.getElementById('stock').value) || 0;
                const currentJumlah = parseInt(this.value) || 0;
                const sisaStock = stockValue - currentJumlah;
                
                // Validate input not greater than available stock
                if (currentJumlah > stockValue) {
                    this.value = stockValue;
                    document.getElementById('sisa_stock').textContent = '0';
                } else {
                    document.getElementById('sisa_stock').textContent = sisaStock;
                }
            });
        });

        // Function to update ID Pengiriman
        function updateIdPengiriman() {
            const cabangSelect = document.getElementById('nama_cabang');
            const namaBarangSelect = document.getElementById('nama_barang');
            const idPengirimanInput = document.getElementById('id_pengiriman');
            const tanggalKeluar = document.querySelector('input[name="tanggal_keluar"]').value;

            if (cabangSelect.value && tanggalKeluar) {
                namaBarangSelect.disabled = false;
                fetch(`/transaksi/get-last-id/${cabangSelect.value}?tanggal=${tanggalKeluar}`)
                    .then(response => response.json())
                    .then(data => {
                        idPengirimanInput.value = data.id_pengiriman;
                    })
                    .catch(error => {
                        console.error('Error fetching ID:', error);
                        idPengirimanInput.value = '';
                    });
            } else {
                namaBarangSelect.disabled = true;
                idPengirimanInput.value = '';
            }
        }

        // Function to print table
        function printTable() {
            window.print();
        }
    </script>
    @endpush
@endsection