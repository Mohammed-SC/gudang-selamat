@extends('layouts.main')

@section('title', 'Barang Masuk')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item">Transaksi</li>
    <li class="breadcrumb-item active">Barang Masuk</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Input Barang Masuk</h3>
        </div>
        <div class="card-body">
            <form id="formBarangMasuk">
                @csrf
                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="text" class="form-control" value="{{ now()->format('Y-m-d') }}" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <select name="barang_id" class="form-control" id="nama_barang" required>
                        <option value="">Pilih Barang</option>
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->id }}" data-stock="{{ $barang->stock }}">
                                {{ $barang->nama_barang }} - {{ $barang->kode_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Stok Saat Ini</label>
                    <input type="text" id="current_stock" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Jumlah Barang Masuk</label>
                    <input type="number" name="jumlah" class="form-control" required min="1">
                </div>

                <div class="form-group">
                    <label>No. Batch</label>
                    <input type="text" name="no_batch" id="no_batch" class="form-control" required>
                    <div id="batch_warning" class="alert alert-danger mt-2" style="display: none;">Nomor batch ini sudah
                        ada!</div>
                </div>

                <div class="form-group">
                    <label>Tanggal Expired</label>
                    <input type="date" name="tanggal_expired" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Data Barang Masuk</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Masuk</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Barang Masuk</th>
                        <th>No. Batch</th>
                        <th>Tanggal Expired</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('Y-m-d') }}</td>
                            <td>{{ $item->namaBarang->nama_barang }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->no_batch }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_expired)->format('Y-m-d') }}</td>
                            <td>
                                <button onclick="deleteBarangMasuk('{{ $item->id }}')"
                                    class="btn btn-danger">Hapus</button>
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
        @page {
            size: landscape;
        }

        body * {
            visibility: hidden;
        }

        #dataTable,
        #dataTable * {
            visibility: visible;
        }

        #dataTable {
            position: absolute;
            left: 0;
            top: 0;
        }
    </style>

    @push('css')
        <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('formBarangMasuk');
                if (form) {
                    form.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        const formData = new FormData(this);
                        const submitButton = this.querySelector('button[type="submit"]');

                        // Disable the submit button to prevent double submission
                        submitButton.disabled = true;

                        try {
                            const response = await fetch('/transaksi/barang-masuk/add', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            });

                            const data = await response.json();

                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.message || 'Data berhasil disimpan',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                throw new Error(data.message || 'Terjadi kesalahan');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: error.message || 'Terjadi kesalahan pada server',
                                confirmButtonText: 'OK'
                            });
                        } finally {
                            submitButton.disabled = false;
                        }
                    });
                } else {
                    console.error('Form element not found');
                }

                // Batch number validation
                document.getElementById('no_batch').addEventListener('input', function() {
                    const batchNumber = this.value.trim();
                    const existingBatches = Array.from(document.querySelectorAll(
                        'table tbody tr td:nth-child(5)')).map(
                        td => td.textContent.trim());

                    const submitButton = document.querySelector('button[type="submit"]');
                    const batchWarning = document.getElementById('batch_warning');

                    if (existingBatches.includes(batchNumber)) {
                        batchWarning.style.display = 'block';
                        submitButton.disabled = true;
                    } else {
                        batchWarning.style.display = 'none';
                        submitButton.disabled = false;
                    }
                });

                // Stock calculation
                document.getElementById('nama_barang').addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const currentStock = selectedOption.dataset.stock || 0;
                    document.getElementById('current_stock').value = currentStock;
                });

                const jumlahInput = document.querySelector('input[name="jumlah"]');
                if (jumlahInput) {
                    jumlahInput.addEventListener('input', function() {
                        // Ensure input is a positive number
                        if (this.value < 1) {
                            this.value = 1;
                        }
                    });
                }
            });

            function deleteBarangMasuk(id) {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/transaksi/barang-masuk/delete/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    if (response.status === 409) {
                                        return response.json().then(data => {
                                            throw new Error(data.message ||
                                                'Data tidak dapat dihapus karena sedang digunakan');
                                        });
                                    }
                                    throw new Error('Terjadi kesalahan saat menghapus data');
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.message || 'Data berhasil dihapus',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: error.message || 'Terjadi kesalahan saat menghapus data',
                                    confirmButtonText: 'OK'
                                });
                            });
                    }
                });
            }

            function deleteBarangMasuk(id) {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/transaksi/barang-masuk/delete/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    if (response.status === 409) {
                                        return response.json().then(data => {
                                            throw new Error(data.message ||
                                                'Data tidak dapat dihapus karena sedang digunakan');
                                        });
                                    }
                                    throw new Error('Terjadi kesalahan saat menghapus data');
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.message || 'Data berhasil dihapus',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: error.message || 'Terjadi kesalahan saat menghapus data',
                                    confirmButtonText: 'OK'
                                });
                            });
                    }
                });
            };
        </script>
    @endpush

@endsection
