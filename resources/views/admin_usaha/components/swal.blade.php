<script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>

{{-- Toast Success / Error --}}
@if (session('swal'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swalData = @json(session()->pull('swal'));

            if (swalData.toast) {
                Swal.fire({
                    toast: true,
                    position: swalData.position || 'top-end',
                    type: swalData.type || 'success',
                    title: swalData.title || '',
                    showConfirmButton: false,
                    timer: swalData.timer || 2500,
                    timerProgressBar: true
                });
            } else {
                // Modal interaktif
                Swal.fire({
                    title: swalData.title || 'Info',
                    text: swalData.text || '',
                    type: swalData.type || 'info',
                    showCancelButton: swalData.showCancelButton ?? false,
                    confirmButtonText: swalData.confirmButtonText || 'OK',
                    cancelButtonText: swalData.cancelButtonText || 'Batal'
                }).then((result) => {
                    if (result.isConfirmed && swalData.onConfirm) {
                        window.location.href = swalData.onConfirm;
                    }
                });
            }
        });
    </script>
@endif
