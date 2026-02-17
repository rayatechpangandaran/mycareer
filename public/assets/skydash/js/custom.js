
document.addEventListener('DOMContentLoaded', function() {

    /* =====================================================
        |  SWEETALERT SUBMIT
        ===================================================== */
    const form = document.getElementById('form-lowongan');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Periksa kembali data lowongan!',
                text: 'Pastikan data yang akan ditambahkan sudah benar.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    }




    /* =====================================================
        |  FORMAT RUPIAH
        ===================================================== */
    function formatRupiah(angka) {
        return 'Rp ' + angka.replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function bindRupiah(inputId, hiddenId) {
        const input = document.getElementById(inputId);
        const hidden = document.getElementById(hiddenId);

        if (!input || !hidden) return;

        input.addEventListener('input', function() {
            const angka = this.value.replace(/\D/g, '');
            hidden.value = angka;
            this.value = formatRupiah(angka);
        });
    }

    bindRupiah('gaji_min', 'gaji_min_value');
    bindRupiah('gaji_max', 'gaji_max_value');


    /* =====================================================
        |  DRAG & DROP BROSUR
        ===================================================== */
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('brosurInput');
    const preview = document.getElementById('previewBrosur');

    if (dropArea && fileInput && preview) {

        dropArea.addEventListener('click', () => fileInput.click());

        dropArea.addEventListener('dragover', e => {
            e.preventDefault();
            dropArea.classList.add('bg-light');
        });

        dropArea.addEventListener('dragleave', () =>
            dropArea.classList.remove('bg-light')
        );

        dropArea.addEventListener('drop', e => {
            e.preventDefault();
            dropArea.classList.remove('bg-light');
            fileInput.files = e.dataTransfer.files;
            previewFile();
        });

        fileInput.addEventListener('change', previewFile);

        function previewFile() {
            const file = fileInput.files[0];
            if (!file) {
                preview.src = "{{ asset('assets/img/brosur/brosur-default.png') }}";
                return;
            }
            const reader = new FileReader();
            reader.onload = () => preview.src = reader.result;
            reader.readAsDataURL(file);
        }
    }


    /* =====================================================
        |  INDO REGION (PROVINSI & KOTA)
        ===================================================== */
    const province = document.getElementById('province');
    const city = document.getElementById('city');
    const lokasiInput = document.getElementById('lokasi');

    if (province && city && lokasiInput) {

        fetch('/provinces')
            .then(res => res.json())
            .then(data => {
                data.forEach(p => {
                    province.innerHTML += `<option value="${p.code}">${p.name}</option>`;
                });
            });

        province.addEventListener('change', function() {
            city.innerHTML = '<option value="">-- Pilih Kota --</option>';
            city.disabled = false;

            fetch(`/cities/${this.value}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.length) {
                        city.innerHTML += `<option value="">(Tidak ada data kota)</option>`;
                    }
                    data.forEach(c => {
                        city.innerHTML +=
                            `<option value="${c.name}">${c.name}</option>`;
                    });
                });
        });

        city.addEventListener('change', function() {
            const provText = province.options[province.selectedIndex].text;
            lokasiInput.value = `${this.value}, ${provText}`;
        });
    }


    /* =====================================================
        |  JURUSAN DINAMIS
        ===================================================== */
    const pendidikan = document.getElementById('pendidikan_terakhir');
    const jurusanWrapper = document.getElementById('jurusanWrapper');
    const jurusanInput = document.getElementById('jurusan');

    if (pendidikan && jurusanWrapper && jurusanInput) {

        function toggleJurusan() {
            if (['D3', 'S1', 'S2', 'S3'].includes(pendidikan.value)) {
                jurusanWrapper.style.display = 'block';
            } else {
                jurusanWrapper.style.display = 'none';
                jurusanInput.value = '';
            }
        }

        pendidikan.addEventListener('change', toggleJurusan);
        toggleJurusan();
    }

});


    document.addEventListener('DOMContentLoaded', function() {

    const filter = document.getElementById('filterStatus');
    const filterIcon = document.getElementById('filterIcon');
    const rows = document.querySelectorAll('#lowonganTable tbody tr[data-status]');
    const emptyRow = document.getElementById('emptyRow');

    function resetIcon() {
        if (!filterIcon) return;
        filterIcon.className = 'mdi mdi-filter me-1 text-muted';
    }

    filter.addEventListener('change', function() {
        const value = this.value;
        let visibleCount = 0;
        let nomor = 1; // 🔥 RESET NOMOR DARI 1

        rows.forEach(row => {
            const status = row.dataset.status;
            const numberCell = row.querySelector('.row-number');

            if (value === 'all' || status === value) {
                row.style.display = '';
                if (numberCell) {
                    numberCell.textContent = nomor++; // 🔥 ISI ULANG NOMOR
                }
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Empty state
        emptyRow.style.display = visibleCount === 0 ? '' : 'none';

        // Warna icon filter
        resetIcon();
        switch (value) {
            case 'Publish':
                filterIcon.classList.add('text-success');
                break;
            case 'Draft':
                filterIcon.classList.add('text-warning');
                break;
            case 'Rejected':
                filterIcon.classList.add('text-danger');
                break;
            case 'Trash':
                filterIcon.classList.add('text-dark');
                break;
            default:
                filterIcon.classList.add('text-muted');
        }
    });
});


        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('lowonganTable');
            const rows = table.querySelectorAll('tbody tr');

            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                let anyVisible = false;

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.indexOf(query) > -1) {
                        row.style.display = '';
                        anyVisible = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Jika tidak ada hasil
                if (!anyVisible) {
                    let tbody = table.querySelector('tbody');
                    let noDataRow = tbody.querySelector('.no-data-search');
                    if (!noDataRow) {
                        const tr = document.createElement('tr');
                        tr.classList.add('no-data-search');
                        tr.innerHTML =
                            '<td colspan="5" class="text-center text-muted"><i class="mdi mdi-magnify"></i> Tidak ada lowongan ditemukan</td>';
                        tbody.appendChild(tr);
                    } else {
                        noDataRow.style.display = '';
                    }
                } else {
                    let noDataRow = table.querySelector('.no-data-search');
                    if (noDataRow) noDataRow.style.display = 'none';
                }
            });
        });
