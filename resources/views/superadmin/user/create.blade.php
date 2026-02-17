@extends('adminlte::page')

@section('title', 'Data Users')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                Tambah Data Users
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Data Users</a></li>
                <li class="breadcrumb-item active">Tambah Data Users</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div id="loadingOverlay" class="d-none"
        style="
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    z-index:9999;
">
        <div
            style="
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%,-50%);
        color:white;
        font-size:18px;
    ">
            <i class="fas fa-spinner fa-spin"></i>
            Sedang memproses...
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="mb-2">
                    <label>Mitra Usaha</label>
                    <select class="form-control" id="mitra_id" name="mitra_id">
                        <option value="">-- Pilih Mitra --</option>
                        @foreach ($mitra as $m)
                            <option value="{{ $m->usaha_id }}">{{ $m->nama_bisnis_usaha }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <label>Email</label>
                    <input type="email" id="email" class="form-control" readonly>
                </div>

                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="text">Simpan</span>
                    <span class="spinner d-none">
                        <i class="fas fa-spinner fa-spin"></i> Memproses...
                    </span>
                </button>

            </form>
        </div>
    </div>


@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const mitraSelect = document.getElementById('mitra_id');
            const emailInput = document.getElementById('email');

            if (mitraSelect && emailInput) {
                mitraSelect.addEventListener('change', function() {
                    const id = this.value;

                    if (!id) {
                        emailInput.value = '';
                        return;
                    }

                    fetch(`{{ url('superadmin/mitra-usaha') }}/${id}`)
                        .then(res => {
                            if (!res.ok) throw new Error('Gagal ambil data mitra');
                            return res.json();
                        })
                        .then(data => {
                            emailInput.value = data.email ?? '';
                        })
                        .catch(err => console.error(err));
                });
            }

            const form = document.querySelector('form');
            const btn = document.getElementById('btnSubmit');

            if (form && btn) {
                form.addEventListener('submit', function() {

                    btn.disabled = true;

                    btn.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                Memproses & mengirim email...
            `;

                    document.getElementById('loadingOverlay')?.classList.remove('d-none');
                });
            }

        });
    </script>
@stop
