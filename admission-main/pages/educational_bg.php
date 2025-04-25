<!DOCTYPE html>
<html lang="en">
<head>
  <title>SPIST Admission - Education</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/educational_bg.css">
  <link rel="stylesheet" href="../assets/styles/form_button.css">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <script src="../components/javascript/profile_dropdown.js"></script>
</head>

<?php
session_start();
include '../components/php/header.php';
include '../components/php/script_educational_bg.php';
?>

<body>
<div class="main-content">
  <section>
    <div class="form-container">
      <div class="form-header">
        <img src="../assets/images/document_logo.png" alt="Document Logo" width="70px" height="90px">
         <div class="form-header-text">
          <h2>Educational Background</h2>
           <p>Last School Attended (Senior High School)</p>
         </div>
      </div>

      <form action="educational_bg.php" method="post">
        <div class="form-grid">
          <div class="row">
            <div class="row2">
              <div class="form-group">
                  <label for="lrn">Learner Reference Number:</label>
                  <input type="text" id="lrn" name="lrn_num" placeholder="If Not Applicable, Enter 0" maxlength="12" required
                         value="<?= htmlspecialchars($_SESSION['lrn_num'] ?? '') ?>">
              </div>
            </div>
          </div>

        <div class="row">
          <div class="row2">
            <div class="form-group">
              <p>School Type:</p>
                <div class="checkbox-container1">
                  <label>
                    <?php if (!isset($_SESSION['school_type'])) {$_SESSION['school_type'] = 'Public';} ?>
                    <input type="radio" name="school_type" value="Public" checked
                    <?= (isset($_SESSION['school_type']) && $_SESSION['school_type'] === 'Public') ? 'checked' : '' ?> required> 
                     Public
                  </label>

                  <label>
                    <input type="radio" name="school_type" value="Private"
                    <?= (isset($_SESSION['school_type']) && $_SESSION['school_type'] === 'Private') ? 'checked' : '' ?>>
                     Private
                  </label>

                  <label>
                    <input type="radio" name="school_type" value="Foreign"
                    <?= (isset($_SESSION['school_type']) && $_SESSION['school_type'] === 'Foreign') ? 'checked' : '' ?>>
                     Foreign
                  </label>
                </div>
              </div>

              <div class="form-group">
                <p>Student Type:</p>
                  <div class="checkbox-container2">
                    <label>
                      <?php if (!isset($_SESSION['student_type'])) {$_SESSION['student_type'] = 'Regular';} ?>
                      <input type="radio" name="student_type" value="Regular" checked
                      <?= (isset($_SESSION['student_type']) && $_SESSION['student_type'] === 'Regular') ? 'checked' : '' ?> required>
                       Regular
                    </label>

                    <label>
                      <input type="radio" name="student_type" value="Balik-Aral"
                      <?= (isset($_SESSION['student_type']) && $_SESSION['student_type'] === 'Balik-Aral') ? 'checked' : '' ?>>
                       Balik-Aral
                    </label>
                  
                    <label>
                      <input type="radio" name="student_type" value="ALS (Alternative Learning System)"
                      <?= (isset($_SESSION['student_type']) && $_SESSION['student_type'] === 'ALS (Alternative Learning System)') ? 'checked' : '' ?>>
                       ALS (Alternative Learning System)
                    </label>  
                  </div>
              </div> 
          </div>
        </div>

        <div class="row">
          <div class="form-group">
            <label for="school-name">School Name:</label>
              <input type="text" id="school-name" name="school_name" required placeholder="Enter School Name"
                     oninput="this.value = this.value.toUpperCase();"
                     value="<?= htmlspecialchars($_SESSION['school_name'] ?? '') ?>">
          </div>
        </div>
        
        <div class="row">
            <div class="form-group">
                <label for="school-address">School Address:</label>
                <input type="text" id="school-address" name="school_address" required placeholder="Enter School Address"
                       oninput="this.value = this.value.toUpperCase();"
                       value="<?= htmlspecialchars($_SESSION['school_address'] ?? '') ?>">
            </div>
        </div>

        <div class="row">
          <div class="row2">
            <div class="form-group">
                <label for="track-strand">Track/Strand:</label>
                <input type="text" id="track-strand" name="track_strand" required placeholder="Enter Your Senior High School Track/Strand"
                       oninput="this.value = this.value.toUpperCase();"     
                       value="<?= htmlspecialchars($_SESSION['track_strand'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label for="year-graduation">Year of Graduation:</label>
              <input type="text" id="year-graduation" name="year_graduation" required placeholder="Enter Year of Graduation" maxlength="4"
                     value="<?= htmlspecialchars($_SESSION['year_graduation'] ?? '') ?>">
            </div>
          </div>
        </div>

        <div class="row">
         <div class="row2">
          <div class="form-group">
              <label for="shs-average">Senior High School General Average:</label>
              <input type="text" id="shs-average" name="shs_average" required placeholder="Enter General Average"
              value="<?= htmlspecialchars($_SESSION['shs_average'] ?? '') ?>">
          </div>
         </div>
        </div>
      </div>

        <div class="button-container">
          <a href="personal_info.php">
            <button id="back-btn" type="button">Back</button>
          </a>
          <button type="submit">Next</button>
        </div>
        
      </form>
    </div>
  </section>
</div>
<script src="../components/javascript/educational_bg.js"></script>
<script src="../components/javascript/check_session_interval.js"></script>
<script src="../components/javascript/autosave.js"></script>
<?php include '../components/php/modal_inactivity.php'; ?>
</body>
<?php include '../components/php/footer.php'; ?>
</html>