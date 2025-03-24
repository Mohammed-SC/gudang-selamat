@extends('layouts.main')

@section('title', 'Penanggung Jawab Cabang')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item">Masterdata</li>
    <li class="breadcrumb-item active">Penanggung Jawab Cabang</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Penanggung Jawab Cabang</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
                <i class="fas fa-plus"></i> Tambah Penanggung Jawab
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
                    <th>Nama Cabang</th>
                    <th>Nama Penanggung Jawab</th>
                    <th>No. Telepon Cabang (CS)</th>
                    <th>No. Telepon Penanggung Jawab (PJ)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->namaCabang->nama_cabang }}</td>
            <td>{{ $item->nama_penanggung_jawab }}</td>
            <td>{{ $item->no_telepon_cs }}</td>
            <td>{{ $item->no_telepon_pj }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-warning" onclick="editPJ({{ $item->id }})">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <form action="{{ url('/master-data/penanggung-jawab-cabang/delete/'.$item->id) }}" method="POST" style="display: inline;">
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
                <h5 class="modal-title" id="modalLabel">Tambah Penanggung Jawab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/master-data/penanggung-jawab-cabang/add') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Cabang</label>
                <select name="nama_cabang_id" class="form-control" required>
                    <option value="">Pilih Cabang</option>
                    @foreach($nama_cabang as $cabang)
                        <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nama Penanggung Jawab</label>
                <input type="text" name="nama_penanggung_jawab" class="form-control" required>
            </div>
            <div class="form-group">
                <label>No. Telepon Cabang (CS)</label>
                <input type="text" name="no_telepon_cs" class="form-control" required maxlength="15">
            </div>
            <div class="form-group">
                <label>No. Telepon Penganngung Jawab (PJ)</label>
                <input type="text" name="no_telepon_pj" class="form-control" required maxlength="15">
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
                <h5 class="modal-title" id="editModalLabel">Edit Penanggung Jawab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nama Cabang</label>
                <select name="nama_cabang_id" id="edit_nama_cabang_id" class="form-control" required>
                    @foreach($nama_cabang as $cabang)
                        <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nama Penanggung Jawab</label>
                <input type="text" name="nama_penanggung_jawab" id="edit_nama_penanggung_jawab" class="form-control" required>
            </div>
            <div class="form-group">
                <label>No. Telepon Cabang (CS)</label>
                <input type="text" name="no_telepon_cs" id="edit_no_telepon_cs" class="form-control" required maxlength="15">
            </div>
            <div class="form-group">
                <label>No. Telepon Penanggung Jawab (PJ)</label>
                <input type="text" name="no_telepon_pj" id="edit_no_telepon_pj" class="form-control" required maxlength="15">
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

function editPJ(id) {
    fetch(`/master-data/penanggung-jawab-cabang/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_nama_cabang_id').value = data.nama_cabang_id;
            document.getElementById('edit_nama_penanggung_jawab').value = data.nama_penanggung_jawab;
            document.getElementById('edit_no_telepon_cs').value = data.no_telepon_cs;
            document.getElementById('edit_no_telepon_pj').value = data.no_telepon_pj;
            document.getElementById('editForm').action = `/master-data/penanggung-jawab-cabang/update/${id}`;
            $('#editModal').modal('show');
        });
}
</script>
@endpush

@endsection