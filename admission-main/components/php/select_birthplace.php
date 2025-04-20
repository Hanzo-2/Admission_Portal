<?php
$json = file_get_contents('../components/json/philippine_provinces_cities_municipalities_and_barangays_2019v2.json');
$data = json_decode($json, true);

$places = [];

foreach ($data as $region) {
    if (!isset($region['province_list'])) continue;

    foreach ($region['province_list'] as $province => $provinceData) {
        if (!isset($provinceData['municipality_list'])) continue;

        foreach ($provinceData['municipality_list'] as $municipality => $municipalityData) {
            $place = $province . ', ' . $municipality; // Province first
            $places[] = $place;
        }
    }
}

// Sort alphabetically
sort($places, SORT_STRING | SORT_FLAG_CASE);

// Echo options and preserve selected value from session
foreach ($places as $place) {
    $safePlace = htmlspecialchars($place);
    $selected = (isset($_SESSION['birthplace']) && $_SESSION['birthplace'] === $place) ? 'selected' : '';
    echo "<option value=\"$safePlace\" $selected>$safePlace</option>";
}
?>