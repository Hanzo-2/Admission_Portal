<?php
session_start();

require_once '../vendor/autoload.php'; // path to your autoload if different
$client = new Google\Client();
$client->setClientId('put id here');
$client->setClientSecret('put secret here');
$client->setRedirectUri('http://localhost/admission_portal/admission-main/pages/admission_application.php');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        $_SESSION['google_id'] = $google_account_info->id; // Store Google ID
        $_SESSION['user'] = [
            'id' => $google_account_info->id,
            'email' => $google_account_info->email,
            'name' => $google_account_info->name,
            'profile_picture' => $google_account_info->picture
        ];

        // Optional: Redirect to clean the URL (remove the "code" GET param)
        header("Location: admission_application.php");
        exit();
    } else {
        echo "Authentication Error: " . htmlspecialchars($token['error']);
        exit();
    }
}

// Redirect to login if not authenticated
if (!isset($_SESSION['google_id'])) {
    header("Location: http://localhost/admission_portal/admission-main/index.php");
    exit();
}

include '../components/php/header.php';
?>

<!DOCTYPE html>
<html lang="en">
  
<head>
<title>SPIST Admission - Application</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/admission_application.css">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <script src="../components/javascript/profile_dropdown.js"></script>
</head>

<body>
  <div class="main-content">
    <section>
      <div class="form-container">
        <div class="form-header">
          <img src="../assets/images/document_logo.png" alt="Document Logo" width="90px" height="120px">
          <div class="form-header-text">
            <h2>Admission Application</h2>
            <p>Welcome to Southern Philippines Institute of Science and Technology</p>
            <p>Please Complete the form for your application</p>
          </div>
        </div>

        <form action="../components/php/database_admission_application.php" method="post">
          <div class="form-grid">
            <div class="form-group-text">
              <label for="school_campus">School Campus:</label>
              <input type="hidden" name="school_campus" value="ANABU">
              <p>ANABU</p>
            </div>
            <div class="form-group-text">
              <label for="classification">Classification:</label>
              <input type="hidden" name="classification" value="College">
              <p>College</p>
            </div>
            <div class="form-group-text">
              <label for="grade_level">Grade/Level:</label>
              <input type="hidden" name="grade_level" value="1st Year">
              <p>1st Year</p>
            </div>
            <div class="form-group-text-space">
              <label for="academic_year_term">Academic Year and Term:</label>
              <input type="hidden" name="academic_year_term" value="2025 - 2026 - First Semester">
              <p>2025 - 2026 - First Semester</p>
            </div>
            <div class="form-group">
              <label for="application_type">Application Type:</label>
              <select name="application_type" required>
                <option value="">Select Application Type</option>
                <option value="New Student/Freshman">New Student/Freshman</option>
                <option value="Transferee">Transferee</option>
                <option value="Second or Additional Course Taker">Second or Additional Course Taker</option>
              </select>
            </div>
            <div class="form-group">
              <p>Preferred Course</p>
              <label for="preferred_course">Academic Program:</label>
              <select name="preferred_course" required>
                <option value="" hidden>Select Preferred Course</option>
                <optgroup label="COLLEGE OF ACCOUNTANCY">
                  <option value="BSA">&emsp;Bachelor of Science in Accountancy</option>
                </optgroup>
                <optgroup label="COLLEGE OF BUSINESS MANAGEMENT">
                  <option value="BSBA">&emsp;Bachelor of Science in Business Administration</option>
                </optgroup>
                <optgroup label="COLLEGE OF EDUCATION">
                  <option value="BEEd">&emsp;Bachelor in Elementary Education</option>
                  <opton value="BSEd">&emsp;Bachelor in Secondary Education</opton>
                </optgroup>
                <optgroup label="COLLEGE OF ENGINEERING AND COMPUTER STUDIES">
                  <option value="BSCpE">&emsp;Bachelor of Science in Computer Engineering</option>
                  <option value="BSCS">&emsp;Bachelor of Science in Computer Science</option>
                  <option value="BSIT">&emsp;Bachelor of Science in Information Techonology</option>
                </optgroup>
                <optgroup label="COLLEGE OF TOURISM AND HOSPITALITY MANAGEMENT">
                  <option value="BSHM">&emsp;Bachelor of Science in Hospitality Management</option>
                  <option value="BSTM">&emsp;Bachelor of Science in Tourism Management</option>
                </optgroup>
              </select>
            </div>
            <div class="button-container">
              <button type="submit">Next</button>
            </div>
          </div>
        </form>
      </div>
    </section>

  </div>
</body>
</html>
<?php include '../components/php/footer.php'; ?>