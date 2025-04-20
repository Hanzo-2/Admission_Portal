<?php
$json = file_get_contents('../components/json/philippine_provinces_cities_municipalities_and_barangays_2019v2.json');
$data = json_decode($json, true);
$provinceList = [];

foreach ($data as $region) {
    if (isset($region['province_list'])) {
        foreach ($region['province_list'] as $provinceName => $provinceData) {
            $provinceList[] = $provinceName;
        }
    }
}

sort($provinceList);

foreach ($provinceList as $province) {
$isSelected = ($province === $selectedProvince) ? 'selected' : '';
echo "<option value=\"" . htmlspecialchars($province) . "\" $isSelected>" . htmlspecialchars($province) . "</option>";
}
?>