@extends('layouts.main')

@section('title', 'List Dosen')

@section('content')
<section class="section custom-section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>List Dosen</h4>
                        <div>
                            <button class="btn btn-primary me-3" data-toggle="modal" data-target="#importModal">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Impor
                            </button>
                            <a href="{{ route('export_dosen') }}" class="btn btn-primary me-3">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Ekspor
                            </a>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="nav-icon fas fa-folder-plus"></i>&nbsp; Tambah Data Dosen
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                                {{ $message }}
                            </div>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dosen</th>
                                        <th>NIDN</th>
                                        <th>Prodi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dosen as $result => $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->nidn }}</td>
                                        <td>{{ $data->prodi->nama_prodi }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('dosen.show', Crypt::encrypt($data->id)) }}" class="btn btn-primary btn-sm" style="margin-right: 8px"><i class="nav-icon fas fa-user"></i> &nbsp; Profile</a>
                                                <a href="{{ route('dosen.edit', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                                <form method="POST" action="{{ route('dosen.destroy', $data->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm show_confirm" data-toggle="tooltip" title='Delete' style="margin-left: 8px"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Data Dosen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                    <span>&times;</span>
                                                </button>
                                                @foreach ($errors->all() as $error )
                                                {{ $error }}
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="nama">Nama Dosen</label>
                                            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="{{ __('Nama Dosen') }}" value="{{ old('nama') }}">
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="form-group">
                                                <label for="nidn">NIDN</label>
                                                <input type="number" id="nidn" name="nidn" class="form-control @error('nidn') is-invalid @enderror" placeholder="{{ __('NIDN Dosen') }}" value="{{ old('nidn') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="no_telp">No. Telp</label>
                                                <input type="number" id="no_telp" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" placeholder="{{ __('No. Telp Dosen') }}" value="{{ old('no_telp') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="prodi_id">Prodi</label>
                                            <select id="prodi_id" name="prodi_id" class="select2 form-control @error('prodi_id') is-invalid @enderror">
                                                <option value="">-- Pilih Prodi --</option>
                                                @foreach ($prodi as $data )
                                                <option value="{{ $data->id }}">{{ $data->nama_prodi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="{{ __('Alamat') }}" value="{{ old('alamat') }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer br">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Impor Data Dosen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('import_dosen') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="file">Pilih file Excel</label>
                                    <input type="file" name="file" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Impor</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `Yakin ingin menghapus data ini?`
                , text: "Data akan terhapus secara permanen!"
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });

</script>
@endpush
