const {
  jsonData,
  selectedProvince,
  selectedCity,
  selectedBarangay
} = window.appData;

const provinceSelect = document.getElementById("province");
const citySelect = document.getElementById("city");
const barangaySelect = document.getElementById("barangay");

function autoSaveField(fieldName, value) {
  fetch('../components/php/autosave.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `field=${encodeURIComponent(fieldName)}&value=${encodeURIComponent(value)}`
  })
    .then(response => response.json())
    .then(data => {
      console.log(`Auto-saved ${fieldName}:`, data);
    })
    .catch(error => {
      console.error('Auto-save error:', error);
    });
}

function populateCities() {
  const province = provinceSelect.value;
  citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
  barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

  for (const regionCode in jsonData) {
    const region = jsonData[regionCode];
    if (!region.province_list) continue;

    const provinces = region.province_list;
    if (provinces[province]) {
      const cities = provinces[province].municipality_list;
      for (const city in cities) {
        const opt = document.createElement('option');
        opt.value = city;
        opt.text = city;
        if (city === selectedCity) opt.selected = true;
        citySelect.appendChild(opt);
      }
    }
  }

  citySelect.dispatchEvent(new Event('change'));

  if (selectedCity) {
    populateBarangays();
  }
}

function populateBarangays() {
  const province = provinceSelect.value;
  const city = citySelect.value;
  barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

  for (const regionCode in jsonData) {
    const region = jsonData[regionCode];
    if (!region.province_list) continue;

    const provinces = region.province_list;
    if (provinces[province]) {
      const cities = provinces[province].municipality_list;
      if (cities[city]) {
        const barangays = cities[city].barangay_list;
        for (const barangay of barangays) {
          const opt = document.createElement('option');
          opt.value = barangay;
          opt.text = barangay;
          if (barangay === selectedBarangay) opt.selected = true;
          barangaySelect.appendChild(opt);
        }
      }
    }
  }

  barangaySelect.dispatchEvent(new Event('change'));
}

provinceSelect.addEventListener("change", function () {
  populateCities();
  autoSaveField('selected_province', provinceSelect.value);
});

citySelect.addEventListener("change", function () {
  populateBarangays();
  autoSaveField('selected_city', citySelect.value);
});

barangaySelect.addEventListener("change", function () {
  autoSaveField('selected_barangay', barangaySelect.value);
});

if (selectedProvince) {
  provinceSelect.value = selectedProvince;
  provinceSelect.dispatchEvent(new Event('change'));
}



