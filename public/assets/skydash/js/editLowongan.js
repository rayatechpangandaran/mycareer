document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       SWEETALERT CONFIRM
    ========================== */
    const form = document.getElementById('form-lowongan');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Perbarui lowongan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, perbarui',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    }

    /* =========================
       FORMAT RUPIAH
    ========================== */
    const rupiah = (val) =>
        'Rp ' + val.replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    ['min', 'max'].forEach(type => {
        const input = document.getElementById(`gaji_${type}`);
        const hidden = document.getElementById(`gaji_${type}_value`);

        if (input && hidden) {
            input.addEventListener('input', function () {
                let number = this.value.replace(/\D/g, '');
                hidden.value = number;
                this.value = rupiah(number);
            });
        }
    });

    /* =========================
       PROVINSI & KOTA
    ========================== */
    const province = document.getElementById('province');
    const city = document.getElementById('city');
    const lokasi = document.getElementById('lokasi');

    // ❗ PENTING: jangan pakai {{ }} di file JS external
    // kirim dari blade pakai window object
    const selectedProv = window.selectedProv || '';
    const selectedCity = window.selectedCity || '';

    if (province && city) {

        fetch('/provinces')
            .then(res => res.json())
            .then(data => {

                province.innerHTML = '<option value="">-- Pilih Provinsi --</option>';

                data.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.code;
                    option.textContent = p.name;

                    if (p.name === selectedProv) {
                        option.selected = true;
                    }

                    province.appendChild(option);
                });

                if (province.value) {
                    loadCity(province.value);
                }
            })
            .catch(err => console.error('Error provinces:', err));

        function loadCity(code) {
            if (!code) return;

            fetch(`/cities/${code}`)
                .then(res => res.json())
                .then(data => {

                    city.disabled = false;
                    city.innerHTML = '<option value="">-- Pilih Kota --</option>';

                    data.forEach(c => {
                        const option = document.createElement('option');
                        option.value = c.name;
                        option.textContent = c.name;

                        if (c.name === selectedCity) {
                            option.selected = true;
                        }

                        city.appendChild(option);
                    });

                    // set lokasi otomatis kalau edit
                    if (selectedCity && selectedProv) {
                        lokasi.value = `${selectedCity}, ${selectedProv}`;
                    }

                })
                .catch(err => console.error('Error cities:', err));
        }

        province.addEventListener('change', function () {
            loadCity(this.value);
        });

        city.addEventListener('change', function () {
            const provText = province.options[province.selectedIndex].text;
            lokasi.value = `${this.value}, ${provText}`;
        });
    }

    /* =========================
       BROSUR PREVIEW
    ========================== */
    const input = document.getElementById('brosurInput');
    const preview = document.getElementById('previewBrosur');
    const dropArea = document.getElementById('drop-area');

    if (input && preview && dropArea) {
        dropArea.onclick = () => input.click();

        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(file);
        });
    }

    /* =========================
       TOGGLE JURUSAN
    ========================== */
    const pendidikan = document.getElementById('pendidikan_terakhir');
    const jurusanWrapper = document.getElementById('jurusanWrapper');
    const jurusanInput = document.getElementById('jurusan');

    if (pendidikan && jurusanWrapper && jurusanInput) {

        function toggleJurusan() {
            const val = pendidikan.value;

            if (['D3', 'S1', 'S2', 'S3'].includes(val)) {
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
