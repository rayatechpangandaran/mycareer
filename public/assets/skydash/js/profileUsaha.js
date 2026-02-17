document.addEventListener('DOMContentLoaded', function () {

    const province = document.getElementById('provinceSelect');
    const city = document.getElementById('citySelect');
    const district = document.getElementById('districtSelect');
    const village = document.getElementById('villageSelect');
    const alamatDetail = document.getElementById('alamatDetail');
    const alamatInput = document.getElementById('alamatLengkap');
    const alamatOld = document.getElementById('alamat_old');

    if (!province) return;

    // Data dari blade
    const oldAddressParts = window.oldAddressParts || [];
    let oldProvince = oldAddressParts[4] || '';
    let oldCity = oldAddressParts[3] || '';
    let oldDistrict = oldAddressParts[2] || '';
    let oldVillage = oldAddressParts[1] || '';

    function resetSelect(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        select.disabled = true;
    }

    function getSelectedText(select) {
        if (!select.value) return '';
        const text = select.options[select.selectedIndex]?.text || '';
        return text.includes('Pilih') ? '' : text;
    }

    function setAlamat() {
        const alamatBaru = [
            alamatDetail.value?.trim() || '',
            getSelectedText(village),
            getSelectedText(district),
            getSelectedText(city),
            getSelectedText(province)
        ].filter(v => v !== '').join(', ');

        alamatInput.value = alamatBaru !== '' ? alamatBaru : (alamatOld?.value || '');
    }

    // ================= PROVINCES =================
    fetch('/provinces')
        .then(res => res.json())
        .then(data => {

            data.forEach(p => {
                const option = document.createElement('option');
                option.value = p.code;
                option.textContent = p.name;

                if (oldProvince.trim() === p.name.trim()) {
                    option.selected = true;
                }

                province.appendChild(option);
            });

            if (province.value) loadCities(province.value, true);
        });

    function loadCities(provinceCode, isInitial = false) {
        resetSelect(city, '-- Pilih Kota/Kabupaten --');
        resetSelect(district, '-- Pilih Kecamatan --');
        resetSelect(village, '-- Pilih Desa --');

        fetch(`/cities/${provinceCode}`)
            .then(res => res.json())
            .then(data => {

                data.forEach(c => {
                    const option = document.createElement('option');
                    option.value = c.code;
                    option.textContent = c.name;

                    if (isInitial && oldCity.trim() === c.name.trim()) {
                        option.selected = true;
                    }

                    city.appendChild(option);
                });

                city.disabled = false;

                if (isInitial && city.value) {
                    loadDistricts(city.value, true);
                }
            });
    }

    function loadDistricts(cityCode, isInitial = false) {
        resetSelect(district, '-- Pilih Kecamatan --');
        resetSelect(village, '-- Pilih Desa --');

        fetch(`/districts/${cityCode}`)
            .then(res => res.json())
            .then(data => {

                data.forEach(d => {
                    const option = document.createElement('option');
                    option.value = d.code;
                    option.textContent = d.name;

                    if (isInitial && oldDistrict.trim() === d.name.trim()) {
                        option.selected = true;
                    }

                    district.appendChild(option);
                });

                district.disabled = false;

                if (isInitial && district.value) {
                    loadVillages(district.value, true);
                }
            });
    }

    function loadVillages(districtCode, isInitial = false) {
        resetSelect(village, '-- Pilih Desa --');

        fetch(`/villages/${districtCode}`)
            .then(res => res.json())
            .then(data => {

                data.forEach(v => {
                    const option = document.createElement('option');
                    option.value = v.code;
                    option.textContent = v.name;

                    if (isInitial && oldVillage.trim() === v.name.trim()) {
                        option.selected = true;
                    }

                    village.appendChild(option);
                });

                village.disabled = false;
            });
    }

    // ================= EVENTS =================
    province.addEventListener('change', function () {
        if (this.value) loadCities(this.value);
        setAlamat();
    });

    city.addEventListener('change', function () {
        if (this.value) loadDistricts(this.value);
        setAlamat();
    });

    district.addEventListener('change', function () {
        if (this.value) loadVillages(this.value);
        setAlamat();
    });

    [village, alamatDetail].forEach(el =>
        el.addEventListener('change', setAlamat)
    );

    setAlamat();

});
