document.addEventListener('DOMContentLoaded', function () {

    const filter = document.getElementById('statusFilter');
    const table = document.getElementById('pelamarTable');
    const overlay = document.getElementById('loadingOverlay');

    if (!table) return;

    const rows = table.querySelectorAll('tbody tr');

    /* =========================
       FILTER STATUS
    ========================== */

    function updateNoDataMessage(status) {
        let text = `
            <div class="text-muted">
                <i class="mdi mdi-database-off fs-1 d-block mb-2"></i>
                <strong>Tidak ditemukan pelamar</strong>
                <div class="small mt-1">Belum ada pelamar diposisi ini</div>
            </div>`;

        if (status === 'Diterima')
            text = text.replace('diposisi ini', 'yang diterima');

        if (status === 'Ditolak')
            text = text.replace('diposisi ini', 'yang ditolak');

        return text;
    }

    function filterRows() {
        const value = filter.value;
        let anyVisible = false;

        rows.forEach(row => {
            if (!row.dataset.status) return;

            if (value === 'all' || row.dataset.status === value) {
                row.style.display = '';
                anyVisible = true;
            } else {
                row.style.display = 'none';
            }
        });

        const noDataRow = table.querySelector('.no-data');

        if (!anyVisible) {
            if (!noDataRow) {
                const tbody = table.querySelector('tbody');
                const tr = document.createElement('tr');
                tr.classList.add('no-data');
                tr.innerHTML =
                    `<td colspan="6" class="text-center text-muted">${updateNoDataMessage(value)}</td>`;
                tbody.appendChild(tr);
            } else {
                noDataRow.querySelector('td').innerHTML = updateNoDataMessage(value);
                noDataRow.style.display = '';
            }
        } else {
            if (noDataRow) noDataRow.style.display = 'none';
        }
    }

    if (filter) {
        filter.addEventListener('change', filterRows);
        filterRows();
    }

    /* =========================
       UPDATE STATUS
    ========================== */

    document.querySelectorAll('.update-status-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {

            e.preventDefault();

            const id = this.dataset.id;
            const status = this.dataset.status;

            if (status === 'Diterima') {
                handleAccept(id);
            } else {
                handleReject(id);
            }
        });
    });

    function handleAccept(id) {
        Swal.fire({
            title: 'Konfirmasi Penerimaan',
            html: `
                <div class="text-start">
                    <label class="form-label fw-semibold">Catatan (Wajib)</label>
                    <textarea id="swal-catatan" class="form-control mb-3"
                        rows="3" placeholder="Tulis catatan..."></textarea>

                    <label class="form-label fw-semibold">Upload Surat (Opsional)</label>
                    <input type="file" id="swal-surat" class="form-control"
                        accept=".pdf,.doc,.docx">
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Terima',
            confirmButtonColor: '#28a745',
            preConfirm: () => {
                const catatan = document.getElementById('swal-catatan').value;
                if (!catatan) {
                    Swal.showValidationMessage('Catatan wajib diisi');
                    return false;
                }

                return {
                    catatan: catatan,
                    surat: document.getElementById('swal-surat').files[0] ?? null
                };
            }
        }).then(result => {

            if (!result.isConfirmed) return;

            overlay.style.display = 'flex';

            const formData = new FormData();
            formData.append('status', 'Diterima');
            formData.append('catatan', result.value.catatan);

            if (result.value.surat) {
                formData.append('surat_diterima', result.value.surat);
            }

            fetch(`/admin_usaha/lamaran/${id}/update-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(res => res.json())
                .then(handleResponse)
                .catch(handleError);
        });
    }

    function handleReject(id) {
        Swal.fire({
            title: 'Yakin menolak pelamar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak',
            confirmButtonColor: '#dc3545'
        }).then(result => {

            if (!result.isConfirmed) return;

            overlay.style.display = 'flex';

            fetch(`/admin_usaha/lamaran/${id}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: JSON.stringify({ status: 'Ditolak' })
            })
                .then(res => res.json())
                .then(handleResponse)
                .catch(handleError);
        });
    }

    function handleResponse(data) {
        overlay.style.display = 'none';

        if (data.success) {
            Swal.fire('Berhasil!', data.message, 'success')
                .then(() => location.reload());
        } else {
            Swal.fire('Gagal!', data.message, 'error');
        }
    }

    function handleError() {
        overlay.style.display = 'none';
        Swal.fire('Error!', 'Terjadi kesalahan server.', 'error');
    }

    /* =========================
   SEND EMAIL / WHATSAPP
========================= */

function sendNotif(type) {

    const btns = document.querySelectorAll(
        type === 'email' ? '.send-email-btn' : '.send-wa-btn'
    );

    btns.forEach(btn => {

        btn.addEventListener('click', function () {

            const id = this.dataset.id;

            Swal.fire({
                title: type === 'email' ? 'Kirim Email?' : 'Kirim WhatsApp?',
                text: 'Apakah Anda yakin ingin mengirim ' +
                    (type === 'email' ? 'email' : 'WhatsApp') +
                    ' pemberitahuan penerimaan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal'
            }).then(result => {

                if (!result.isConfirmed) return;

                overlay.style.display = 'flex';

                fetch(`/admin_usaha/lamaran/${id}/send-notif`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ type: type })
                })
                    .then(res => res.json())
                    .then(data => {

                        overlay.style.display = 'none';

                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success');
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    })
                    .catch(err => {

                        overlay.style.display = 'none';

                        Swal.fire('Error!', 'Terjadi kesalahan server.', 'error');
                        console.error(err);
                    });
            });

        });

    });
}

sendNotif('email');
sendNotif('whatsapp');

});



