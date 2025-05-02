<!DOCTYPE html>
<html lang="en">
<head>
  <title>SPIST Admission - Personal</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/personal_info.css">
  <link rel="stylesheet" href="../assets/styles/form_button.css">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <script src="../components/javascript/profile_dropdown.js"></script>
</head>

<?php 
session_start();
include '../components/php/script_personal_info.php';
include '../components/php/header.php'; 
?>

<body>
  <div class="main-content">
    <section>
      <div class="form-container">
        <div class="form-header">
          <img src="../assets/images/document_logo.png" alt="Document Logo" class="header-logo">
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
                       oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);"
                       value="<?= htmlspecialchars($_SESSION['personal_firstname'] ?? '') ?>">
              </div>

              <div class="form-group">
                <label for="personal-middlename">Middle Name:</label>
                <input type="text" id="personal-middlename" name="personal_middlename" placeholder="Middle Name (Optional)" 
                       oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);"
                       value="<?= htmlspecialchars($_SESSION['personal_middlename'] ?? '') ?>">
              </div>

              <div class="form-group">
                <label for="personal-surname">Surname:</label>
                <input type="text" id="personal-surname" name="personal_surname" required placeholder="Surname" 
                       oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);"
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
                    <?php include '../components/php/select_birthplace.php'; ?>
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

              <div class="form-group">
                <label for="nationality">Nationality:</label>
                  <select id="nationality" name="nationality" required>
                    <option value="">Choose your Nationality</option>
                      <?php 
                        $selectedNationality = $_SESSION['nationality'] ?? '';
                        include '../components/php/select_nationality.php' 
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
                <label for="address">House No., Street Name:</label>
                  <input type="text" id="address" name="address" required placeholder="House No., Street Name" autocomplete="address"
                         oninput="this.value = this.value.toUpperCase();"       
                         value="<?= htmlspecialchars($_SESSION['address'] ?? '') ?>">
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <label for="province">Province/Region:</label>
                  <select id="province" name="selected_province" class="form-control" required>
                    <option value="">Select Province/Region</option>
                      <?php 
                        $selectedProvince = $_SESSION['selected_province'] ?? '';
                        $selectedCity = $_SESSION['selected_city'] ?? '';
                        $selectedBarangay = $_SESSION['selected_barangay'] ?? '';
                        include '../components/php/select_province.php'
                      ?>
                  </select>
              </div>

              <div class="form-group">
                <label for="city">City/Municipality:</label>
                  <select id="city" name="selected_city" class="form-control" required>
                    <option value="">Select City/Municipality</option>
                  </select>
              </div>

              <div class="form-group">
                <label for="barangay">Barangay:</label>
                  <select id="barangay" name="selected_barangay" class="form-control" required>
                    <option value="">Select Barangay</option>
                  </select>
              </div>
          </div>

          <script>
            window.appData = {
              jsonData: <?= json_encode($data); ?>,
              selectedProvince: <?= json_encode($selectedProvince); ?>,
              selectedCity: <?= json_encode($selectedCity); ?>,
              selectedBarangay: <?= json_encode($selectedBarangay); ?>
            };
          </script>

          <h3> Personal Contact Information </h3>
            <div class="row">
              <div class="form-group">
                <label for="personal-contact">Contact Number:</label>
                  <input type="tel" id="personal-contact" name="personal_contact" maxlength="13"
                         placeholder="Enter Phone Number" required
                         value="<?= htmlspecialchars($_SESSION['personal_contact'] ?? '') ?>"
                         oninput="formatvalidatePhoneNumber(this)">
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                  <input type="email" id="email" name="personal_email" placeholder="Enter Email Address (Optional)" autocomplete="email"
                         value="<?= htmlspecialchars($_SESSION['personal_email'] ?? '') ?>"
                         oninput="validateEmail(this)">
              </div>

              <div class="form-group">
                <label for="telephone">Telephone Number:</label> 
                  <input type="tel" id="telephone" name="telephone" placeholder="Enter Tel. No. (Optional)" maxlength="13"
                         value="<?= htmlspecialchars($_SESSION['telephone'] ?? '') ?>"
                         oninput="formatvalidateTelephone(this)">
              </div>
            </div>
         </div> 

        <div class="button-container">
          <a href="admission_application.php"> 
            <button id="back-btn" type="button">Back</button> 
          </a>
            <button type="submit">Next</button>
        </div>
      
      </form>
    </div>
  </section>
</div>
<script src="../components/javascript/format_validate.js"></script>
<script src="../components/javascript/check_session_interval.js"></script>
<script src="../components/javascript/autosave.js"></script>
<script src="../components/javascript/select_province_city_barangay.js"></script>
<?php include '../components/php/modal_inactivity.php'; ?>
</body>
<?php include '../components/php/footer.php'; ?>
</html>