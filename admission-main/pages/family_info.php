<!DOCTYPE html>
<html lang="en">
<head>
  <title>SPIST Admission - Family</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/family_info.css">
  <link rel="stylesheet" href="../assets/styles/form_button.css">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <script src="../components/javascript/profile_dropdown.js"></script>
</head>

<?php 
session_start(); 
include '../components/php/script_family_info.php';
include '../components/php/header.php';
?>

<body>
<div class="main-content">
  <section>
    <div class="form-container">
      <div class="form-header">
        <img src="../assets/images/docu-logo-4.png" alt="Document Logo" class="header-logo-4">
        <div class="form-header-text">
          <h2 class="form-title">Family Information</h2>
          <p>First Semester, 2025 - 2026</p>
        </div>
      </div>

      <form action="family_info.php" method="post">
        <div class="form-grid">
            <div class="button-container-return">
                <?php if (isset($_GET['from']) && $_GET['from'] === 'review'): ?>
                  <a href="review_info.php">
                    <button type="button" id="return-btn">&#8617; Return to Review Information</button>
                  </a>
                <?php endif; ?>
            </div>
           <h2>Father's Name</h2>

            <div class="row">
              <div class="form-group">
                <label for="father-firstname">First Name:</label>
                  <input type="text" id="father-firstname" name="father_firstname" placeholder="First Name"
                         value="<?= htmlspecialchars($_SESSION['father_firstname'] ?? '') ?>">
              </div>
    
              <div class="form-group">
                <label for="father-middlename">Middle Name:</label>
                  <input type="text" id="father-middlename" name="father_middlename" placeholder="Middle Name (Optional)"
                         value="<?= htmlspecialchars($_SESSION['father_middlename'] ?? '') ?>">
              </div>
    
              <div class="form-group">
                <label for="father-surname">Surname:</label>
                  <input type="text" id="father-surname" name="father_surname" placeholder="Surname"
                         value="<?= htmlspecialchars($_SESSION['father_surname'] ?? '') ?>">
              </div>
            </div>
    
            <div class="row">
              <div class="row2">
                <div class="form-group">
                  <label for="father-birthdate">Date of Birth:</label>
                    <input type="date" id="father-birthdate" name="father_birthdate"
                           min="1900-01-01" max="2099-12-31"
                           value="<?= htmlspecialchars($_SESSION['father_birthdate'] ?? '') ?>">
                </div>
    
                <div class="form-group">
                  <label for="father-contact">Contact Number:</label>
                    <input type="tel" id="father-contact" name="father_contact" maxlength="13" 
                           placeholder="Enter Phone Number"
                           value="<?= htmlspecialchars($_SESSION['father_contact'] ?? '') ?>"
                           oninput="formatvalidatePhoneNumber(this)">
                </div>
              </div>
            </div>
        </div>

        <div class="form-grid">
          <h1>Mother's Name</h1>
            <div class="row">
              <div class="form-group">
                <label for="mother-firstname">First Name:</label>
                  <input type="text" id="mother-firstname" name="mother_firstname" placeholder="First Name"
                         value="<?= htmlspecialchars($_SESSION['mother_firstname'] ?? '') ?>">
              </div>
    
              <div class="form-group">
                <label for="mother-middlename">Middle Name:</label>
                  <input type="text" id="mother-middlename" name="mother_middlename" placeholder="Middle Name (Optional)"
                         value="<?= htmlspecialchars($_SESSION['mother_middlename'] ?? '') ?>">
              </div>
    
              <div class="form-group">
                <label for="mother-surname">Surname:</label>
                  <input type="text" id="mother-surname" name="mother_surname" placeholder="Surname"
                         value="<?= htmlspecialchars($_SESSION['mother_surname'] ?? '') ?>">
              </div>
            </div>
    
            <div class="row">
              <div class="row2">
                <div class="form-group">
                  <label for="mother-birthdate">Date of Birth:</label>
                    <input type="date" id="mother-birthdate" name="mother_birthdate" min="1900-01-01" max="2099-12-31"
                           value="<?= htmlspecialchars($_SESSION['mother_birthdate'] ?? '') ?>">
                </div>
    
                <div class="form-group">
                  <label for="mother-contact">Contact Number:</label>
                    <input type="tel" id="mother-contact" name="mother_contact" maxlength="13" 
                           placeholder="Enter Phone Number"
                           value="<?= htmlspecialchars($_SESSION['mother_contact'] ?? '') ?>" 
                           oninput="formatvalidatePhoneNumber(this)">
                </div>
              </div>
            </div>
        </div>

        <div class="form-grid">
          <h1>Guardian's Name</h1>
            <div class="row">
                <div class="form-group">
                  <label for="guardian-firstname">First Name:</label>
                    <input type="text" id="guardian-firstname" name="guardian_firstname" required placeholder="First Name"
                           value="<?= htmlspecialchars($_SESSION['guardian_firstname'] ?? '') ?>">
                </div>
    
                <div class="form-group">
                  <label for="guardian-middlename">Middle Name:</label>
                    <input type="text" id="guardian-middlename" name="guardian_middlename" placeholder="Middle Name (Optional)"
                           value="<?= htmlspecialchars($_SESSION['guardian_middlename'] ?? '') ?>">
                </div>
    
                <div class="form-group">
                  <label for="guardian-surname">Surname:</label>
                    <input type="text" id="guardian-surname" name="guardian_surname" required placeholder="Surname"
                           value="<?= htmlspecialchars($_SESSION['guardian_surname'] ?? '') ?>">
                </div>
            </div>

            <div class="row">
              <div class="form-group">
                <label for="guardian-address">Present Address:</label>
                  <input type="text" id="guardian-address" name="guardian_address" required placeholder="Enter Present Address"
                          oninput="this.value = this.value.toUpperCase();"
                          value="<?= htmlspecialchars($_SESSION['guardian_address'] ?? '') ?>">
              </div>
            </div>

            <div class="row">
              <div class="form-group">
                <label for="guardian-province">Province/Region:</label>
                  <select id="guardian-province" name="guardian_province" required>
                    <option value="">Select Province/Region</option>
                      <?php 
                        $guardianProvince = $_SESSION['guardian_province'] ?? '';
                        $guardianCity = $_SESSION['guardian_city'] ?? '';
                        $guardianBarangay = $_SESSION['guardian_barangay'] ?? '';
                        include '../components/php/select_province.php';
                      ?>
                  </select>
              </div>
  
              <div class="form-group">
                <label for="guardian-city">City/Municipality:</label>
                  <select id="guardian-city" name="guardian_city" required>
                    <option value="">Select City/Municipality</option>
                  </select>
              </div>

              <div class="form-group">
                <label for="guardian-barangay">Barangay:</label>
                  <select id="guardian-barangay" name="guardian_barangay" required>
                    <option value="">Select Barangay</option>
                  </select>
              </div>
            </div>

            <script>
              window.guardianAppData = {
                jsonData: <?= json_encode($data); ?>,
                guardianProvince: <?= json_encode($_SESSION['guardian_province'] ?? ''); ?>,
                guardianCity: <?= json_encode($_SESSION['guardian_city'] ?? ''); ?>,
                guardianBarangay: <?= json_encode($_SESSION['guardian_barangay'] ?? ''); ?>
              };
            </script>
    
            <div class="row2">
              <div class="form-group">
                <label for="guardian-contact">Contact Number:</label>
                  <input type="tel" id="guardian-contact" name="guardian_contact" maxlength="13" 
                         placeholder="Enter Phone Number" required
                         value="<?= htmlspecialchars($_SESSION['guardian_contact'] ?? '') ?>"
                         oninput="formatvalidatePhoneNumber(this)">
              </div>
        
              <div class="form-group">
                <label for="guardian-email">Email:</label>
                  <input type="email" id="guardian-email" name="guardian_email" placeholder="Enter Email Address (Optional)"
                         value="<?= htmlspecialchars($_SESSION['guardian_email'] ?? '') ?>"
                         oninput="validateEmail(this)">
              </div>
        
              <div class="form-group">
                <label for="guardian-telephone">Telephone Number:</label>
                  <input type="tel" id="guardian-telephone" name="guardian_telephone" placeholder="Enter Tel. No. (Optional)" maxlength="13"
                         value="<?= htmlspecialchars($_SESSION['guardian_telephone'] ?? '') ?>"
                         oninput="formatvalidateTelephone(this)">
              </div>
            </div>
        </div>

        <div class="form-grid">
          <h3>Person to Contact in Case of Emergency</h3>
            <div class="row">
              <div class="form-group">
                <label class="emergency-complete-name" for="emergency-complete-name">Complete Name:</label>
                  <div class="input-container-emergency">
                    <input type="text" id="emergency-complete-name" name="emergency_complete_name" required placeholder="Enter Name or Select from List"
                           value="<?= htmlspecialchars($_SESSION['emergency_complete_name'] ?? '') ?>">
                      <select name="emergency_complete_name_select" id="emergency_complete_name_select">
                        <option value="">Select to Autofill</option>
                        <option value="Father" <?=(isset($_SESSION['emergency_complete_name_select']) && $_SESSION['emergency_complete_name_select'] == "Father") ? 'selected' : '' ?>>Father</option>
                        <option value="Mother" <?=(isset($_SESSION['emergency_complete_name_select']) && $_SESSION['emergency_complete_name_select'] == "Mother") ? 'selected' : '' ?>>Mother</option>
                        <option value="Guardian" <?=(isset($_SESSION['emergency_complete_name_select']) && $_SESSION['emergency_complete_name_select'] == "Guardian") ? 'selected' : '' ?>>Guardian</option>
                        <option value="None" <?=(isset($_SESSION['emergency_complete_name_select']) && $_SESSION['emergency_complete_name_select'] == "None") ? 'selected' : '' ?>>None</option>
                      </select>
                  </div>
              </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label class="emergency-complete-address" for="emergency-complete-address">Complete Address:</label>
                    <input type="text" id="emergency-complete-address" name="emergency_complete_address" required placeholder="Enter Complete Address"
                           oninput="this.value = this.value.toUpperCase();"
                           value="<?= htmlspecialchars($_SESSION['emergency_complete_address'] ?? '') ?>">
                </div>
            </div>
            
            <div class="row2">
                <div class="form-group">
                    <label for="emergency-contact">Contact Number:</label>
                    <input type="tel" id="emergency-contact" name="emergency_contact" maxlength="13" 
                           placeholder="Enter Phone Number" required 
                           value="<?= htmlspecialchars($_SESSION['emergency_contact'] ?? '') ?>"
                           oninput="formatvalidatePhoneNumber(this)">
                  </div>
        
                  <div class="form-group">
                    <label for="emergency-email">Email:</label>
                    <input type="email" id="emergency-email" name="emergency_email" placeholder="Enter Email Address (Optional)"
                           value="<?= htmlspecialchars($_SESSION['emergency_email'] ?? '') ?>"
                           oninput="validateEmail(this)">
                  </div>
        
                  <div class="form-group">
                    <label for="emergency-telephone">Telephone Number:</label>
                    <input type="tel" id="emergency-telephone" name="emergency_telephone" placeholder="Enter Tel. No. (Optional)" maxlength="13"
                           value="<?= htmlspecialchars($_SESSION['emergency_telephone'] ?? '') ?>"      
                           oninput="formatvalidateTelephone(this)">
                  </div>
              </div>
        </div>
    
        <div class="button-container">
          <a href="educational_bg.php"> 
            <button id="back-btn" type="button">Back</button> 
          </a>
            <button type="submit">Next</button>
        </div>

        </form>
      </div>
    </section>
  </div>
<script>
    const sessionAddress = "<?= addslashes($_SESSION['address'] ?? '') ?>";
    const sessionProvince = "<?= addslashes($_SESSION['selected_province'] ?? '') ?>";
    const sessionCity = "<?= addslashes($_SESSION['selected_city'] ?? '') ?>";
    const sessionBarangay = "<?= addslashes($_SESSION['selected_barangay'] ?? '') ?>";
</script>
<script src="../components/javascript/format_validate.js"></script>
<script src="../components/javascript/family_info.js"></script>
<script src="../components/javascript/check_session_interval.js"></script>
<script src="../components/javascript/autosave.js"></script>
<script src="../components/javascript/select_province_city_barangay.js"></script>
<?php include '../components/php/modal_inactivity.php'; ?>
</body>
<?php include '../components/php/footer.php'; ?>
</html>