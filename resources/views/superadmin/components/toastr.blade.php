<script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>

@if (session('toast_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                type: 'success',
                title: '{{ session()->pull('toast_success') }}',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        });
    </script>
@endif

@if (session('toast_error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                type: 'error',
                title: '{{ session()->pull('toast_error') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
@endif


@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($errors->all() as $error)
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    type: 'error', // v8 pakai type
                    title: "{{ $error }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endforeach
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('btn-logout');
        if (btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                $('#logoutModal').modal('show');
            });
        }
    });
</script>
