<!DOCTYPE html>
<html lang="en">
<head>
  <title>SPIST Admission - Application</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="../assets/styles/admission_application.css">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <script src="../components/javascript/profile_dropdown.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php 
session_start();
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
$client = new Google\Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
$client->addScope("email");
$client->addScope("profile");
include '../components/php/script_admission_application.php' 
?>

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

        <form action="admission_application.php" method="post">
          <div class="form-grid">
          <div class="form-group-text">
            <label for="school_campus">School Campus:</label>
            <input type="hidden" name="school_campus" value="<?= htmlspecialchars($_SESSION['school_campus'] ?? 'ANABU') ?>">
            <p><?= htmlspecialchars($_SESSION['school_campus'] ?? 'ANABU') ?></p>
            </div>

            <div class="form-group-text">
            <label for="classification">Classification:</label>
            <input type="hidden" name="classification" value="<?= htmlspecialchars($_SESSION['classification'] ?? 'College') ?>">
            <p><?= htmlspecialchars($_SESSION['classification'] ?? 'College') ?></p>
            </div>

            <div class="form-group-text">
            <label for="grade_level">Grade/Level:</label>
            <input type="hidden" name="grade_level" value="<?= htmlspecialchars($_SESSION['grade_level'] ?? '1st Year') ?>">
            <p><?= htmlspecialchars($_SESSION['grade_level'] ?? '1st Year') ?></p>
            </div>

            <div class="form-group-text-space">
            <label for="academic_year_term">Academic Year and Term:</label>
            <input type="hidden" name="academic_year_term" value="<?= htmlspecialchars($_SESSION['academic_year_term'] ?? '2025 - 2026 - First Semester') ?>">
            <p><?= htmlspecialchars($_SESSION['academic_year_term'] ?? '2025 - 2026 - First Semester') ?></p>
            </div>

            <div class="form-group">
              <label for="application_type">Application Type:</label>
              <select name="application_type" required>
                <option value="">Select Application Type</option>
                <option value="New Student/Freshman" <?= (isset($_SESSION['application_type']) && $_SESSION['application_type'] == "New Student/Freshman") ? 'selected' : '' ?>>New Student/Freshman</option>
                <option value="Transferee" <?= (isset($_SESSION['application_type']) && $_SESSION['application_type'] == "Transferee") ? 'selected' : '' ?>>Transferee</option>
                <option value="Second or Additional Course Taker" <?= (isset($_SESSION['application_type']) && $_SESSION['application_type'] == "Second or Additional Course Taker") ? 'selected' : '' ?>>Second or Additional Course Taker</option>
              </select>
            </div>
            <div class="form-group">
              <p>Preferred Course</p>
              <label for="preferred_course">Academic Program:</label>
              <select name="preferred_course" required>
                <option value="" hidden>Select Preferred Course</option>
                <optgroup label="COLLEGE OF ACCOUNTANCY">
                  <option value="BSA" <?= (isset($_SESSION['preferred_course']) && $_SESSION['preferred_course'] == "BSA") ? 'selected' : '' ?>>&emsp;Bachelor of Science in Accountancy</option>
                </optgroup>
                <optgroup label="COLLEGE OF BUSINESS MANAGEMENT">
                  <option value="BSBA" <?= (isset($_SESSION['preferred_course']) && $_SESSION['preferred_course'] == "BSBA") ? 'selected' : '' ?>>&emsp;Bachelor of Science in Business Administration</option>
                </optgroup>
                <optgroup label="COLLEGE OF EDUCATION">
                  <option value="BEEd" <?= (isset($_SESSION['preferred_course']) && $_SESSION['preferred_course'] == "BEEd") ? 'selected' : '' ?>>&emsp;Bachelor in Elementary Education</option>
                  <option value="BSEd" <?= (isset($_SESSION['preferred_course']) && $_SESSION['preferred_course'] == "BSEd") ? 'selected' : '' ?>>&emsp;Bachelor in Secondary Education</option>
                </optgroup>
                <optgroup label="COLLEGE OF ENGINEERING AND COMPUTER STUDIES">
                  <option value="BSCpE" <?= (isset($_SESSION['preferred_course']) && $_SESSION['preferred_course'] == "BSCpE") ? 'selected' : '' ?>>&emsp;Bachelor of Science in Computer Engineering</option>
                  <option value="BSCS" <?= (isset($_SESSION['preferred_course']) && $_SESSION['preferred_course'] == "BSCS") ? 'selected' : '' ?>>&emsp;Bachelor of Science in Computer Science</option>
                  <option value="BSIT" <?= (isset($_SESSION['preferred_course']) && $_SESSION['preferred_course'] == "BSIT") ? 'selected' : '' ?>>&emsp;Bachelor of Science in Information Technology</option>  
                </optgroup>
                <optgroup label="COLLEGE OF TOURISM AND HOSPITALITY MANAGEMENT">
                  <option value="BSHM" <?= (isset($_SESSION['preferred_course']) && $_SESSION['preferred_course'] == "BSHM") ? 'selected' : '' ?>>&emsp;Bachelor of Science in Hospitality Management</option>
                  <option value="BSTM" <?= (isset($_SESSION['preferred_course']) && $_SESSION['preferred_course'] == "BSTM") ? 'selected' : '' ?>>&emsp;Bachelor of Science in Tourism Management</option>
                </optgroup>
              </select>
            </div>
            <div class="button-container">
              <button type="submit">Next</button>
            </div>
          </div>
        </form>
          <?php if (isset($_SESSION['application_type']) || isset($_SESSION['preferred_course'])): ?>
            <div class="submitted-data" style="margin-top: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 5px;">
                <h3>Submitted Information Preview:</h3>
                <ul>
                <li><strong>School Campus:</strong> <?= htmlspecialchars($_SESSION['school_campus'] ?? 'Not set') ?></li>
                <li><strong>Classification:</strong> <?= htmlspecialchars($_SESSION['classification'] ?? 'Not set') ?></li>
                <li><strong>Grade/Level:</strong> <?= htmlspecialchars($_SESSION['grade_level'] ?? 'Not set') ?></li>
                <li><strong>Academic Year and Term:</strong> <?= htmlspecialchars($_SESSION['academic_year_term'] ?? 'Not set') ?></li>
                <li><strong>Application Type:</strong> <?= htmlspecialchars($_SESSION['application_type'] ?? 'Not set') ?></li>
                <li><strong>Preferred Course:</strong> <?= htmlspecialchars($_SESSION['preferred_course'] ?? 'Not set') ?></li>
                </ul>
            </div>
          <?php endif; ?>
      </div>
    </section>
  </div>
  <script src="../components/javascript/admission_application.js"></script>
  <script src="../components/javascript/check_session_interval.js"></script>
</body>
</html>
<?php include '../components/php/footer.php'; ?>