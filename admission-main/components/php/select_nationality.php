<?php
$json = file_get_contents('../components/json/country_nationality_map.json');
$nationalities = json_decode($json, true);

asort($nationalities);

foreach ($nationalities as $country => $nationality) {
    // Set 'Filipino' as the default selection
    $selected = ($selectedNationality === $nationality || $nationality === 'Filipino') ? 'selected' : ''; 
    echo "<option value=\"" . htmlspecialchars($nationality) . "\" $selected>" . htmlspecialchars($nationality) . "</option>";
}
?>
