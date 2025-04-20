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
  <script src="../components/modal/profile_dropdown.js"></script>
</head>

<?php 
session_start(); 
include '../components/php/script_family_info.php';
?>

<body>
<div class="main-content">
  <section>
    <div class="form-container">
      <div class="form-header">
        <img src="../assets/images/document_logo.png" alt="Document Logo" width="65px" height="75px">
        <div class="form-header-text">
          <h2>Family Information</h2>
          <p>First Semester, 2025 - 2026</p>
        </div>
      </div>

      <form action="family_info.php" method="post">
        <div class="form-grid">
           <h2>Father's Name</h2>

            <div class="row">
                <div class="form-group">
                    <label for="father-firstname">First Name:</label>
                    <input type="text" id="father-firstname" name="father_firstname" placeholder="First Name">
                </div>
    
                <div class="form-group">
                    <label for="father-middlename">Middle Name:</label>
                    <input type="text" id="father-middlename" name="father_middlename" placeholder="Middle Name (Optional)">
                </div>
    
                <div class="form-group">
                    <label for="father-surname">Surname:</label>
                    <input type="text" id="father-surname" name="father_surname" placeholder="Surname">
                </div>
            </div>
    
            <div class="row">
              <div class="row2">
                <div class="form-group">
                    <label for="father-birthdate">Date of Birth:</label>
                    <input type="date" id="father-birthdate" name="father_birthdate" min="1900-01-01" max="2099-12-31">
                </div>
    
                <div class="form-group">
                    <label for="father-contact">Contact Number:</label>
                    <input type="tel" id="father-contact" name="father_contact" maxlength="14" 
                          placeholder="Enter 11-digit phone number"
                          oninput="formatPhoneNumber(this)">
                </div>
              </div>
            </div>
        </div>

        <div class="form-grid">
            <h1>Mother's Name</h1>
            <div class="row">
                <div class="form-group">
                    <label for="mother-firstname">First Name:</label>
                    <input type="text" id="mother-firstname" name="mother_firstname" placeholder="First Name">
                </div>
    
                <div class="form-group">
                    <label for="mother-middlename">Middle Name:</label>
                    <input type="text" id="mother-middlename" name="mother_middlename" placeholder="Middle Name (Optional)">
                </div>
    
                <div class="form-group">
                    <label for="mother-surname">Surname:</label>
                    <input type="text" id="mother-surname" name="mother_surname" placeholder="Surname">
                </div>
            </div>
    
            <div class="row">
              <div class="row2">
                <div class="form-group">
                    <label for="mother-birthdate">Date of Birth:</label>
                    <input type="date" id="mother-birthdate" name="mother_birthdate" min="1900-01-01" max="2099-12-31">
                </div>
    
                <div class="form-group">
                    <label for="mother-contact">Contact Number:</label>
                    <input type="tel" id="mother-contact" name="mother_contact" maxlength="14" 
                          placeholder="Enter 11-digit phone number" 
                          oninput="formatPhoneNumber(this)">
                </div>
              </div>
            </div>
        </div>

        <div class="form-grid">
            <h1>Guardian's Name</h1>
            <div class="row">
                <div class="form-group">
                    <label for="guardian-firstname">First Name:</label>
                    <input type="text" id="guardian-firstname" name="guardian_firstname" required placeholder="First Name">
                </div>
    
                <div class="form-group">
                    <label for="guardian-middlename">Middle Name:</label>
                    <input type="text" id="guardian-middlename" name="guardian_middlename" placeholder="Middle Name (Optional)">
                </div>
    
                <div class="form-group">
                    <label for="guardian-surname">Surname:</label>
                    <input type="text" id="guardian-surname" name="guardian_surname" required placeholder="Surname">
                </div>
            </div>

            <div class="row">
              <div class="row2">
                <div class="form-group">
                    <label for="guardian-address">Present Address:</label>
                    <input type="text" id="guardian-address" name="guardian_address" required placeholder="Enter Guardian’s Present Address">
                </div>
    
                <div class="form-group">
                    <label for="guardian-province">Province/Region:</label>
                    <select id="guardian-province" name="guardian_province" required>
                    <option value="">Select Province/Region</option>
                    <option value="Cavite">Cavite</option>
                    <!-- Add options here -->
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="guardian-city">City:</label>
                    <select id="guardian-city" name="guardian_city" required>
                    <option value="">Select City</option>
                    <option value="Imus City">Imus City</option>
                    <!-- Add options here -->
                    </select>
                </div>
              </div>
            </div>
    
            <div class="row2">
                <div class="form-group">
                    <label for="guardian-contact">Contact Number:</label>
                    <input type="tel" id="guardian-contact" name="guardian_contact" maxlength="14" 
                          placeholder="Enter 11-digit phone number" required 
                          oninput="formatPhoneNumber(this)">
                  </div>
        
                  <div class="form-group">
                    <label for="guardian-email">Email:</label>
                    <input type="email" id="guardian-email" name="guardian_email" placeholder="Enter Email Address (Optional)">
                  </div>
        
                  <div class="form-group">
                    <label for="guardian-telephone">Telephone Number:</label>
                    <input type="tel" id="guardian-telephone" name="guardian_telephone" placeholder="Enter Tel. No. (Optional)" maxlength="12"
                          oninput="formatTelephone(this)">
                  </div>
            </div>
        </div>

        <div class="form-grid">
        <h3>Person to Contact in Case of Emergency</h3>
            <div class="row">
              <div class="form-group">
                <label class="complete-name" for="complete-name">Complete Name:</label>
                <div class="input-container-emergency">
                    <input type="text" id="complete-name" name="complete_name" required placeholder="Enter Emergency Contact Name or Select from List">
                    <select name="complete_name_select">
                        <option value="">Pick from List</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Guardian">Guardian</option>
                        <option value="None">None</option>
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label class="complete-address" for="complete-address">Complete Address:</label>
                    <input type="text" id="complete-address" name="complete_address" required placeholder="Enter Emergency Contact Address">
                </div>
            </div>

            
            <div class="row2">
                <div class="form-group">
                    <label for="emergency-contact">Contact Number:</label>
                    <input type="tel" id="emergency-contact" name="emergency_contact" maxlength="14" 
                          placeholder="Enter 11-digit phone number" required 
                          oninput="formatPhoneNumber(this)">
                  </div>
        
                  <div class="form-group">
                    <label for="emergency-email">Email:</label>
                    <input type="email" id="emergency-email" name="emergency_email" placeholder="Enter Email Address (Optional)">
                  </div>
        
                  <div class="form-group">
                    <label for="emergency-telephone">Telephone Number:</label>
                    <input type="tel" id="emergency-telephone" name="emergency_telephone" placeholder="Enter Tel. No. (Optional)" maxlength="12"
                          oninput="formatTelephone(this)">
                  </div>
            </div>
        </div>
    
        <div class="button-container">
          <a href="educational_bg.php" style="text-decoration: none"> <button id="back-btn" type="button">Back</button> </a>
            <button type="submit">Next</button>
        </div>

    </form>

      </div>
    </section>
  </div>
<script src="../components/family_info.js"></script>
<script src="../components/javascript/check_session_interval.js"></script>
<script src="../components/javascript/autosave.js"></script>
<?php include '../components/php/modal_inactivity.php'; ?>
</body>
<?php include '../components/php/footer.php'; ?>
</html>