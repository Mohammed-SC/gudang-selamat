@extends('layouts.main')

@section('title', 'Nama Cabang')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item">Masterdata</li>
    <li class="breadcrumb-item active">Nama Cabang</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Nama Cabang</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
                <i class="fas fa-plus"></i> Tambah Cabang
            </button>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Cabang</th>
                    <th>Nama Cabang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_cabang }}</td>
                    <td>{{ $item->nama_cabang }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning" onclick="editCabang({{ $item->id }})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ url('/master-data/nama-cabang/delete/'.$item->id) }}" method="POST" style="display: inline;">
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
                <h5 class="modal-title" id="modalLabel">Tambah Nama Cabang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/master-data/nama-cabang/add" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Kode Cabang</label>
                        <input type="text" name="kode_cabang" class="form-control" required maxlength="10">
                    </div>
                    <div class="form-group">
                        <label>Nama Cabang</label>
                        <input type="text" name="nama_cabang" class="form-control" required>
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
                <h5 class="modal-title" id="editModalLabel">Edit Nama Cabang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Kode Cabang</label>
                        <input type="text" name="kode_cabang" id="edit_kode_cabang" class="form-control" required maxlength="10">
                    </div>
                    <div class="form-group">
                        <label>Nama Cabang</label>
                        <input type="text" name="nama_cabang" id="edit_nama_cabang" class="form-control" required>
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

function editCabang(id) {
    fetch(`/master-data/nama-cabang/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_kode_cabang').value = data.kode_cabang;
            document.getElementById('edit_nama_cabang').value = data.nama_cabang;
            document.getElementById('editForm').action = `/master-data/nama-cabang/update/${id}`;
            $('#editModal').modal('show');
        });
}
</script>
@endpush

@endsection