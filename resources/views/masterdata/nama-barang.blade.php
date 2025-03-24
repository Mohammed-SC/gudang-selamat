@extends('layouts.main')

@section('title', 'Nama Barang')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item">Masterdata</li>
    <li class="breadcrumb-item active">Nama Barang</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Nama Barang</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
                <i class="fas fa-plus"></i> Tambah Barang
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Satuan Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jenisBarang ? $item->jenisBarang->jenis : $item->jenis_barang }}</td>
                    <td>{{ $item->satuanBarang ? $item->satuanBarang->satuan : $item->satuan_barang }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning" onclick="editBarang('{{ $item->kode_barang }}')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ url('/master-data/nama-barang/delete/'.$item->kode_barang) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Nama Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/master-data/nama-barang/add" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Jenis Barang</label>
                        <select name="jenis_barang" class="form-control" required>
                            <option value="">Pilih Jenis Barang</option>
                            @foreach($jenis_barang as $jenis)
                                <option value="{{ $jenis->jenis }}">{{ $jenis->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Satuan Barang</label>
                        <select name="satuan_id" class="form-control" required>
                            <option value="">Pilih Satuan Barang</option>
                            @foreach($satuan_barang as $satuan)
                                <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Nama Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Kode Barang</label>
                        <input type="text" name="kode_barang" id="edit_kode_barang" class="form-control" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" id="edit_nama_barang" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Jenis Barang</label>
                        <select name="jenis_barang" id="edit_jenis_barang" class="form-control" required>
                            <option value="">Pilih Jenis Barang</option>
                            @foreach($jenis_barang as $jenis)
                                <option value="{{ $jenis->jenis }}">{{ $jenis->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Satuan Barang</label>
                        <select name="satuan_barang_id" id="edit_satuan_barang" class="form-control" required>
                            <option value="">Pilih Satuan Barang</option>
                            @foreach($satuan_barang as $satuan)
                                <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
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
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        responsive: true,
        autoWidth: false
    });
});

function editBarang(kode_barang) {
    fetch(`/master-data/nama-barang/${kode_barang}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_kode_barang').value = data.kode_barang;
            document.getElementById('edit_nama_barang').value = data.nama_barang;
            document.getElementById('edit_jenis_barang').value = data.jenis_barang;
            document.getElementById('edit_satuan_barang').value = data.satuan_barang_id;
            document.getElementById('editForm').action = `/master-data/nama-barang/update/${kode_barang}`;
            $('#editModal').modal('show');
        });
}
</script>
@endpush

@endsection
