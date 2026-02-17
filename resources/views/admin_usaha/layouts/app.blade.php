<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/mdi/css/materialdesignicons.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- <link rel="stylesheet" href="assets/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/css/custom.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/img/logoCareer.jpeg') }}" />
</head>

<body>
    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        @include('admin_usaha.layouts.partials.navbar')

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('admin_usaha.layouts.partials.sidebar')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('admin_usaha.layouts.partials.footer')

                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/skydash/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/skydash/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/skydash/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <!-- <script src="assets/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="{{ asset('assets/skydash/js/dataTables.select.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/skydash/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/template.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/settings.js') }}"></script>
    <script src="{{ asset('assets/skydash/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('assets/skydash/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/skydash/js/dashboard.js') }}"></script>
    <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->
    @stack('scripts')

    @if (session()->has('swal'))
        @php $swal = session('swal'); @endphp

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    toast: {{ $swal['toast'] ? 'true' : 'false' }},
                    position: "center",
                    icon: "{{ $swal['type'] ?? 'success' }}",
                    title: "{{ $swal['title'] ?? '' }}",
                    text: "{{ $swal['text'] ?? '' }}",
                    showConfirmButton: {{ $swal['toast'] ? 'false' : 'true' }},
                    timer: {{ $swal['toast'] ? 3000 : 'null' }}
                });
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'Perbaiki',
                confirmButtonColor: '#dc3545'
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#28a745'
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const logoutBtn = document.querySelector('.btn-logout');

            if (!logoutBtn) return;

            logoutBtn.addEventListener('click', function() {

                Swal.fire({
                    title: 'Yakin ingin logout?',
                    text: 'Anda akan keluar dari sistem.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }

                });

            });

        });
    </script>
</body>

</html>
