<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['google_id'])) {
    header("Location: http://localhost/admission_portal/admission-main/index.php");
    exit();
}

include '../components/php/header.php';

if (isset($_SESSION['google_id'])) {
    echo "Session is active for user ID: " . $_SESSION['google_id'];
} else {
    echo "Session not active.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['personal_firstname'] = $_POST['personal_firstname'] ?? '';
    $_SESSION['personal_middlename'] = $_POST['personal_middlename'] ?? '';
    $_SESSION['personal_surname'] = $_POST['personal_surname'] ?? '';
    $_SESSION['personal_birthdate'] = $_POST['personal_birthdate'] ?? '';
    $_SESSION['birthplace'] = $_POST['birthplace'] ?? '';
    $_SESSION['sex'] = $_POST['sex'] ?? '';
    $_SESSION['civilstatus'] = $_POST['civilstatus'] ?? '';
    $_SESSION['nationality'] = $_POST['nationality'] ?? '';
    $_SESSION['religion'] = $_POST['religion'] ?? '';
    $_SESSION['address'] = $_POST['address'] ?? '';
    $_SESSION['selected_province'] = $_POST['province'] ?? '';
    $_SESSION['selected_city'] = $_POST['city'] ?? '';
    $_SESSION['selected_barangay'] = $_POST['barangay'] ?? '';
    $_SESSION['personal_contact'] = $_POST['personal_contact'] ?? '';
    $_SESSION['email'] = $_POST['email'] ?? '';
    $_SESSION['telephone'] = $_POST['telephone'] ?? '';

    if (!empty($_SESSION['selected_province']) && !empty($_SESSION['selected_city'])) {
        // Redirect if valid
        header('Location: educational_bg.php'); // change to your next page
        exit();
    } else {
        $error = "Please fill out all required fields.";
    }
}

?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <title>SPIST Admission - Personal</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <link rel="stylesheet" href="../assets/styles/personal_info.css">
  <script src="../components/javascript/profile_dropdown.js"></script>
</head>
<body>
  <div class="main-content">
    <section>
      <div class="form-container">
        <div class="form-header">
          <img src="../assets/images/document_logo.png" alt="Document Logo" width="65px" height="75px">
          <div class="form-header-text">
            <h2>Personal Information</h2>
            <p>First Semester, 2025 - 2026</p>
          </div>
        </div>
        <form action="personal_info.php" method="post">
          <div class="form-grid">
            <div class="row">
              <div class="form-group">
                <label for="personal-firstname">First Name:</label>
                <input type="text" id="personal-firstname" name="personal_firstname" required placeholder="First Name" 
                    value="<?= htmlspecialchars($_SESSION['personal_firstname'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="personal-middlename">Middle Name:</label>
                <input type="text" id="personal-middlename" name="personal_middlename" placeholder="Middle Name (Optional)" 
                    value="<?= htmlspecialchars($_SESSION['personal_middlename'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="personal-surname">Surname:</label>
                <input type="text" id="personal-surname" name="personal_surname" required placeholder="Surname" 
                    value="<?= htmlspecialchars($_SESSION['personal_surname'] ?? '') ?>">
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <label for="personal-birthdate">Date of Birth:</label>
                <input type="date" id="personal-birthdate" name="personal_birthdate"
                    min="1900-01-01" max="2099-12-31" required
                    value="<?= htmlspecialchars($_SESSION['personal_birthdate'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label for="birthplace">Place of Birth:</label>
                <select id="birthplace" name="birthplace" required>
                    <option value="">Choose your Place of Birth</option>
                    <?php
                        $json = file_get_contents('../components/json/philippine_provinces_cities_municipalities_and_barangays_2019v2.json');
                        $data = json_decode($json, true);

                        $places = [];

                        foreach ($data as $region) {
                            if (!isset($region['province_list'])) continue;

                            foreach ($region['province_list'] as $province => $provinceData) {
                                if (!isset($provinceData['municipality_list'])) continue;

                                foreach ($provinceData['municipality_list'] as $municipality => $municipalityData) {
                                    $place = $municipality . ', ' . $province;
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
                </select>
            </div>

              <div class="form-group">
                <label for="sex">Sex:</label>
                <select id="sex" name="sex" required>
                  <option value="">Choose your Sex at birth</option>
                  <option value="Male" <?=(isset($_SESSION['sex'])&& $_SESSION['sex'] == "Male")? 'selected' : '' ?>>Male</option>
                  <option value="Female" <?=(isset($_SESSION['sex'])&& $_SESSION['sex'] == "Female")? 'selected' : '' ?>>Female</option>
                  <option value="Prefer not to say" <?=(isset($_SESSION['sex'])&& $_SESSION['sex'] == "Prefer not to say")? 'selected' : '' ?>>Prefer not to say</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <label for="civilstatus">Civil Status:</label>
                <select id="civilstatus" name="civilstatus" required>
                  <option value="">Choose your Civil status</option>
                  <option value="Single" <?=(isset($_SESSION['civilstatus'])&& $_SESSION['civilstatus'] == "Single")? 'selected' : '' ?>>Single</option>
                  <option value="Married" <?=(isset($_SESSION['civilstatus'])&& $_SESSION['civilstatus'] == "Married")? 'selected' : '' ?>>Married</option>
                  <option value="Divorced" <?=(isset($_SESSION['civilstatus'])&& $_SESSION['civilstatus'] == "Divorced")? 'selected' : '' ?>>Divorced</option>
                  <option value="Widowed" <?=(isset($_SESSION['civilstatus'])&& $_SESSION['civilstatus'] == "Widowed")? 'selected' : '' ?>>Widowed</option>
                  <option value="Prefer not to say" <?=(isset($_SESSION['civilstatus'])&& $_SESSION['civilstatus'] == "Prefer not to say")? 'selected' : '' ?>>Prefer not to say</option>
                </select>
              </div>
                <?php $selectedNationality = $_SESSION['nationality'] ?? ''; ?>
                <div class="form-group">
                <label for="nationality">Nationality:</label>
                <select id="nationality" name="nationality" required>
                    <option value="">Choose your Nationality</option>
                    <?php
                    $json = file_get_contents('../components/json/country_nationality_map.json');
                    $nationalities = json_decode($json, true);

                    asort($nationalities);

                    foreach ($nationalities as $country => $nationality) {
                        $selected = ($selectedNationality === $nationality) ? 'selected' : ''; 
                        echo "<option value=\"" . htmlspecialchars($nationality) . "\" $selected>" . htmlspecialchars($nationality) . "</option>";
                    }
                    ?>
                </select>
                </div>
                <div class="form-group">
                <label for="religion">Religion:</label>
                <select name="religion" id="religion" required>
                    <option value="">Select Religion</option>
                    <option value="Roman Catholic" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Roman Catholic") ? 'selected' : '' ?>>Roman Catholic</option>
                    <option value="Islam" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Islam") ? 'selected' : '' ?>>Islam</option>
                    <option value="Iglesia ni Cristo" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Iglesia ni Cristo") ? 'selected' : '' ?>>Iglesia ni Cristo</option>
                    <option value="Evangelical" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Evangelical") ? 'selected' : '' ?>>Evangelical</option>
                    <option value="Born Again Christian" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Born Again Christian") ? 'selected' : '' ?>>Born Again Christian</option>
                    <option value="Seventh-day Adventist" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Seventh-day Adventist") ? 'selected' : '' ?>>Seventh-day Adventist</option>
                    <option value="Jehovah's Witnesses" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Jehovah's Witnesses") ? 'selected' : '' ?>>Jehovah's Witnesses</option>
                    <option value="Buddhism" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Buddhism") ? 'selected' : '' ?>>Buddhism</option>
                    <option value="Hinduism" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Hinduism") ? 'selected' : '' ?>>Hinduism</option>
                    <option value="Other" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "Other") ? 'selected' : '' ?>>Other</option>
                    <option value="None" <?= (isset($_SESSION['religion']) && $_SESSION['religion'] === "None") ? 'selected' : '' ?>>None</option>
                </select>
                </div>
            </div>
            
            <h3>Current Address (Philippines) </h3>
            <input type="hidden" name="country" value="<?= htmlspecialchars($_SESSION['country'] ?? 'Philippines') ?>">
            
            <div class="row">
            <div class="form-group">
                <label for="address" style="margin-top: 1px;">House No., Street Name:</label>
                <input type="text" id="address" name="address" required placeholder="House No., Street Name"
                    value="<?= htmlspecialchars($_SESSION['address'] ?? '') ?>">
            </div>
            </div>

            <?php
            $selectedProvince = $_SESSION['selected_province'] ?? '';
            $selectedCity = $_SESSION['selected_city'] ?? '';
            $selectedBarangay = $_SESSION['selected_barangay'] ?? '';

            $json = file_get_contents('../components/json/philippine_provinces_cities_municipalities_and_barangays_2019v2.json');
            $data = json_decode($json, true);
            ?>

            <div class="row">
            <div class="form-group">
                <label for="province">Province/Region:</label>
                <select id="province" name="province" class="form-control" required>
                <option value="">Select Province/Region</option>
                <?php
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
                </select>
            </div>

            <div class="form-group">
                <label for="city">City/Municipality:</label>
                <select id="city" name="city" class="form-control" required>
                <option value="">Select City/Municipality</option>
                </select>
            </div>

            <div class="form-group">
                <label for="barangay">Barangay:</label>
                <select id="barangay" name="barangay" class="form-control" required>
                <option value="">Select Barangay</option>
                </select>
            </div>
            </div>

            <script>
            const jsonData = <?php echo json_encode($data); ?>;
            const selectedProvince = <?= json_encode($selectedProvince); ?>;
            const selectedCity = <?= json_encode($selectedCity); ?>;
            const selectedBarangay = <?= json_encode($selectedBarangay); ?>;

            const provinceSelect = document.getElementById("province");
            const citySelect = document.getElementById("city");
            const barangaySelect = document.getElementById("barangay");

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

                if (selectedCity) {
                populateBarangays(); // Prepopulate barangays
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
            }

            provinceSelect.addEventListener("change", populateCities);
            citySelect.addEventListener("change", populateBarangays);

            // Prepopulate on page load
            if (selectedProvince) {
                populateCities();
            }
            </script>
            <h3> Personal Contact Information </h3>
            <div class="row">
            <div class="form-group">
                <label for="personal_contact" style="margin-top: 1px">Contact Number:</label>
                <input type="tel" id="personal-contact" name="personal_contact" maxlength="14"
                    placeholder="Enter 11-digit phone number" required
                    value="<?= htmlspecialchars($_SESSION['personal_contact'] ?? '') ?>"
                    oninput="formatPhoneNumber(this)">
            </div>

            <div class="form-group">
                <label for="email" style="margin-top: 1px">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter Email Address (Optional)"
                    value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="telephone" style="margin-top: 1px">Telephone Number:</label>
                <input type="tel" id="telephone" name="telephone" placeholder="Enter Tel. No. (Optional)" maxlength="12"
                    value="<?= htmlspecialchars($_SESSION['telephone'] ?? '') ?>"
                    oninput="formatTelephone(this)">
            </div>
            </div>
          </div>
          <div class="button-container">
            <a href="admission_application.php" style="text-decoration: none"> <button id="back-btn" type="button">Back</button> </a>
            <button type="submit">Next</button>
          </div>
        </form>

        <?php if (isset($_SESSION['application_type']) || isset($_SESSION['preferred_course'])): ?>
        <div class="submitted-data" style="margin-top: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 5px;">
            <h4>Submitted Information Preview:</h4>
            <ul>
            <li><strong>Firstname:</strong> <?= htmlspecialchars($_SESSION['personal_firstname'] ?? 'Not set') ?></li>
            <li><strong>Middlename:</strong> <?= htmlspecialchars($_SESSION['personal_middlename'] ?? 'Not set') ?></li>
            <li><strong>Surname:</strong> <?= htmlspecialchars($_SESSION['personal_surname'] ?? 'Not set') ?></li>
            <li><strong>Birthdate:</strong> <?= htmlspecialchars($_SESSION['personal_birthdate'] ?? 'Not set') ?></li>
            <li><strong>Birthplace:</strong> <?= htmlspecialchars($_SESSION['birthplace'] ?? 'Not set') ?></li>
            <li><strong>Sex:</strong> <?= htmlspecialchars($_SESSION['sex'] ?? 'Not set') ?></li>
            <li><strong>Nationality:</strong> <?= htmlspecialchars($_SESSION['nationality'] ?? 'Not set') ?></li>
            <li><strong>Religion:</strong> <?= htmlspecialchars($_SESSION['religion'] ?? 'Not set') ?></li>
            <li><strong>Address:</strong> <?= htmlspecialchars($_SESSION['address'] ?? 'Not set') ?></li>
            <li><strong>Province:</strong> <?= htmlspecialchars($_SESSION['selected_province'] ?? 'Not set') ?></li>
            <li><strong>City:</strong> <?= htmlspecialchars($_SESSION['selected_city'] ?? 'Not set') ?></li>
            <li><strong>Barangay:</strong> <?= htmlspecialchars($_SESSION['selected_barangay'] ?? 'Not set') ?></li>
            <li><strong>Contact Number:</strong> <?= htmlspecialchars($_SESSION['personal_contact'] ?? 'Not set') ?></li>
            <li><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email'] ?? 'Not set') ?></li>
            <li><strong>Telephone:</strong> <?= htmlspecialchars($_SESSION['telephone'] ?? 'Not set') ?></li>
            </ul>
        </div>
        <?php endif; ?>
      </div>
    </section>
  </div>
</body>
</html>
<?php include '../components/php/footer.php'; ?>
<script src="../components/javascript/personal_info.js"></script>
<script src="../components/javascript/check_session_interval.js"></script>