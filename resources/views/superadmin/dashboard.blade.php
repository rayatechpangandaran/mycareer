@extends('adminlte::page')

@section('title', 'Dashboard Superadmin')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    {{-- Info Cards --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['totalMitra'] }}</h3>
                    <p>Mitra Usaha</p>
                </div>
                <div class="icon"><i class="fas fa-building"></i></div>
                <a href="{{ route('mitra.index') }}" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['totalLowongan'] }}</h3>
                    <p>Lowongan</p>
                </div>
                <div class="icon"><i class="fas fa-briefcase"></i></div>
                <a href="{{ route('superadmin.lowongan.index') }}" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['totalUsers'] }}</h3>
                    <p>Pengguna</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ route('users.index') }}" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['totalArtikel'] }}</h3>
                    <p>Artikel</p>
                </div>
                <div class="icon"><i class="fas fa-newspaper"></i></div>
                <a href="{{ route('articles.index') }}" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Pertumbuhan (6 Bulan Terakhir)</h3>
                </div>
                <div class="card-body"><canvas id="trendChart" style="height: 300px;"></canvas></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Status Lowongan</h3>
                </div>
                <div class="card-body"><canvas id="donutChart" style="height: 300px;"></canvas></div>
            </div>
        </div>
    </div>

    {{-- Recent Jobs Table --}}
    <div class="card card-dark card-outline">
        <div class="card-header border-transparent">
            <h3 class="card-title font-weight-bold">Lowongan Terbaru</h3>
        </div>
        <div class="card-body p-2">
            <div class="table-responsive">
                <table class="table m-2 table-hover">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Perusahaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowonganTerbaru as $loker)
                            <tr>
                                <td><span class="font-weight-bold">{{ $loker->judul }}</span></td>
                                <td>{{ $loker->nama_bisnis_usaha }}</td>
                                <td>
                                    <span
                                        class="badge {{ $loker->status == 'Publish' ? 'badge-success' : 'badge-danger' }} px-3">
                                        {{ ucfirst($loker->status) }}
                                    </span>
                                </td>
                                <td><a href="{{ route('superadmin.lowongan.show', $loker->id) }}"
                                        class="btn btn-xs btn-outline-primary">Detail</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Data masih kosong.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    @include('superadmin.components.logout-modal')
    @include('superadmin.components.toastr')
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function() {
            // Line Chart: Trend Pertumbuhan
            new Chart($('#trendChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                            label: 'User Baru',
                            data: {!! json_encode($dataUser) !!},
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0,123,255,0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Lowongan',
                            data: {!! json_encode($dataLoker) !!},
                            borderColor: '#28a745',
                            fill: false,
                            borderDash: [5, 5]
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Donut Chart: Status Lowongan
            new Chart($('#donutChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($statusLowongan->pluck('status')) !!},
                    datasets: [{
                        data: {!! json_encode($statusLowongan->pluck('total')) !!},
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6c757d']
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@stop
