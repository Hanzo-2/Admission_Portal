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

?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <title>SPIST Admission - Education</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <link rel="stylesheet" href="../assets/styles/educational_bg.css">
  <script src="../components/javascript/profile_dropdown.js"></script>
</head>

<body>
<div id="header"></div>  <!-- Header -->
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

    <form action="#" method="post">
      <div class="form-grid">
        <div class="row">
          <div class="row2">
            <div class="form-group">
                <label for="lrn">Learner Reference Number:</label>
                <input type="text" id="lrn" name="lrn_num" placeholder="If Not Applicable, Enter 0" maxlength="12" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="row2">
            <div class="form-group">
              <label for="school-type">School Type:</label>
              <div class="checkbox-container1">
                <label><input type="radio" name="school_type" value="Public" required>Public</label>
                <label><input type="radio" name="school_type" value="Private">Private</label>
                <label><input type="radio" name="school_type" value="Foreign">Foreign</label>
              </div>
            </div> 

            <div class="form-group">
              <label for="student-type">Student Type:</label>
              <div class="checkbox-container2">
                <label><input type="radio" name="student_type" value="Regular" required checked>Regular</label>
                <label><input type="radio" name="student_type" value="Balik-Aral">Balik-Aral</label>
                <label><input type="radio" name="student_type" value="ALS (Alternative Learning System)">ALS (Alternative Learning System)</label>
              </div>
            </div> 
            
          </div>
        </div>

        <div class="row">
              <div class="form-group">
                  <label for="school-name">School Name:</label>
                  <input type="text" id="school-name" name="school_name" required placeholder="Enter School Name">
              </div>
        </div>
        
        <div class="row">
            <div class="form-group">
                <label for="school-address">School Address:</label>
                <input type="text" id="school-address" name="school_address" required placeholder="Enter School Address">
            </div>
        </div>

        <div class="row">
          <div class="row2">
            <div class="form-group">
                <label for="track-strand">Track/Strand:</label>
                <input type="text" id="track-strand" name="track_strand" required placeholder="Enter Your Senior High School Track/Strand">
            </div>

            <div class="form-group">
              <label for="year-graduation">Year of Graduation:</label>
              <input type="text" id="year-graduation" name="year_graduation" required placeholder="Enter Year of Graduation" maxlength="4">
            </div>
          </div>
        </div>

        <div class="row">
         <div class="row2">
          <div class="form-group">
              <label for="shs-average">Senior High School General Average:</label>
              <input type="text" id="shs-average" name="shs_average" required placeholder="Enter General Average">
          </div>
         </div>
        </div>
      </div>

        <div class="button-container">
            <a href="personal_info.php" style="text-decoration: none"><button id="back-btn" type="button">Back</button></a>
            <button type="submit">Next</button>
        </div>
    </form>

    </div>
  </section>
</div>

</body>
</html>
<?php include '../components/php/footer.php'; ?>
<script src="../components/javascript/educational_bg.js"></script>
<script src="../components/javascript/check_session_interval.js"></script>