<?php
$json = file_get_contents('../components/json/country_nationality_map.json');
$nationalities = json_decode($json, true);

asort($nationalities);

if (!isset($_SESSION['nationality'])) {
    $_SESSION['nationality'] = 'Filipino';
}

foreach ($nationalities as $country => $nationality) {
    // Set 'Filipino' as the default selection
    $selected = ($selectedNationality === $nationality || $nationality === 'Filipino') ? 'selected' : ''; 
    echo "<option value=\"" . htmlspecialchars($nationality) . "\" $selected>" . htmlspecialchars($nationality) . "</option>";
}

