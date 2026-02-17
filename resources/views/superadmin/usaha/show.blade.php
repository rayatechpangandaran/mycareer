@extends('adminlte::page')

@section('title', 'Detail Request')
@section('css')
    <style>
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, .8);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@section('content_header')

    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                Detail Request Mitra Usaha
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.usaha.index') }}">Request</a></li>
                <li class="breadcrumb-item active">Request Detail</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div id="loadingOverlay" class="loading-overlay d-none">
            <div class="spinner-border text-danger" role="status"></div>
            <p class="mt-2">Memproses penolakan...</p>
        </div>

        {{-- KIRI : DETAIL USAHA --}}
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-building"></i> Informasi Usaha
                    </h3>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="35%">Nama Usaha</th>
                            <td>{{ $usaha->nama_bisnis_usaha }}</td>
                        </tr>
                        <tr>
                            <th width="35%">NIB</th>
                            <td>
                                @if ($usaha->nib == 0)
                                    Belum ada NIB
                                @else
                                    {{ $usaha->nib }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Penanggung Jawab</th>
                            <td>{{ $usaha->nama_penanggung_jawab }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $usaha->email }}</td>
                        </tr>
                        <tr>
                            <th>No WhatsApp</th>
                            <td>{{ $usaha->no_wa }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Lengkap</th>
                            <td>{{ $usaha->alamat_lengkap }}, {{ $usaha->kota }}</td>
                        </tr>
                        <tr>
                            <th>Bidang Usaha</th>
                            <td>{{ $usaha->bidang_usaha }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Karyawan</th>
                            <td>{{ $usaha->jml_karyawan }} orang</td>
                        </tr>
                    </table>

                    <hr>

                    <h5 class="mb-2">
                        <i class="fas fa-align-left"></i> Deskripsi Usaha
                    </h5>

                    <div class="p-3 bg-light rounded">
                        {{ $usaha->deskripsi_perusahaan ?? 'Tidak ada deskripsi usaha.' }}
                    </div>

                    <hr>

                    {{-- ACTION BUTTON --}}
                    @if ($usaha->is_verify == 0)
                        <div class="mt-3">
                            <form class="d-inline">
                                @csrf
                                <button class="btn btn-success  btn-approve" data-id="{{ $usaha->usaha_id }}">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>

                            <button class="btn btn-danger ml-2" data-toggle="modal" data-target="#rejectModal">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </div>
                    @else
                        <div class="alert alert-info mt-3 mb-0">
                            Request ini sudah diproses.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KANAN : BUKTI USAHA --}}
        <div class="col-md-4">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt"></i> Bukti Usaha
                    </h3>
                </div>

                <div class="card-body text-center">
                    @if ($usaha->bukti_usaha)
                        @php
                            $fileUrl = asset('storage/' . $usaha->bukti_usaha);
                            $ext = strtolower(pathinfo($usaha->bukti_usaha, PATHINFO_EXTENSION));
                        @endphp

                        {{-- IMAGE --}}
                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                            <img src="{{ $fileUrl }}" class="img-fluid img-thumbnail mb-2">

                            {{-- PDF --}}
                        @elseif ($ext === 'pdf')
                            <iframe src="{{ $fileUrl }}" width="100%" height="400" style="border:1px solid #ddd">
                            </iframe>
                        @else
                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-download"></i> Download File
                            </a>
                        @endif

                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-link btn-sm mt-2">
                            <i class="fas fa-external-link-alt"></i> Buka di tab baru
                        </a>
                    @else
                        <span class="text-muted">
                            Bukti usaha belum diupload
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL REJECT --}}
    <div class="modal fade" id="rejectModal">
        <div class="modal-dialog">
            <form class="formReject" method="POST" action="{{ route('superadmin.usaha.reject', $usaha->usaha_id) }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title">
                            <i class="fas fa-times"></i> Tolak Usaha
                        </h5>
                    </div>
                    <div class="modal-body">
                        <label>Alasan Penolakan</label>
                        <textarea name="alasan" class="form-control" rows="4" placeholder="Masukkan alasan penolakan secara jelas..."
                            required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btnReject">
                            Kirim Penolakan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('superadmin.components.toastr')
@endsection
@section('js')
    <script>
        $('.btn-approve').on('click', function(e) {
            e.preventDefault();

            let usahaId = $(this).data('id');

            Swal.fire({
                title: 'Verifikasi Usaha?',
                text: 'Akun admin usaha akan dibuat dan email dikirim',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745',
                reverseButtons: true,
            }).then((result) => {

                if (result.value) {

                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang membuat akun & mengirim email',
                        allowOutsideClick: false,
                        onOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: `/superadmin/usaha/${usahaId}/approve`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire({
                                type: 'success',
                                title: 'Berhasil!',
                                text: res.message || 'Usaha berhasil diverifikasi',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => location.reload());
                        },
                        error: function() {
                            Swal.fire({
                                type: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan'
                            });
                        }
                    });
                }
            });
        });
        document.querySelectorAll('.formReject').forEach(form => {
            form.addEventListener('submit', function() {
                document.getElementById('loadingOverlay').classList.remove('d-none');
            });
        });
    </script>
@endsection
