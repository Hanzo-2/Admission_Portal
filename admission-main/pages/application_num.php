<!DOCTYPE html>
<html lang="en">
<head>
  <title>SPIST Admission - Submitted</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/application_num.css">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <script src="../components/javascript/profile_dropdown.js"></script>
</head>
<?php
session_start();
require_once __DIR__ . '/../components/php/db.php';

// Assume the Google ID is stored in the session after login
$googleId = $_SESSION['google_id'] ?? null;

$applicantEmail = 'Not available';
$dateSubmitted = 'Not available';
$timeSubmitted = 'Not available';
$admissionNumber = 'Not available';

if ($googleId !== null) {
    try {
        // Query to check if an application already exists for this Google ID
        $stmt = $pdo->prepare("SELECT email, date_submitted, time_submitted, admission_number 
                               FROM applications 
                               WHERE google_id = ?");
        $stmt->execute([$googleId]);

        $result = $stmt->fetch();

        if ($result) {
            // Application found, display details
            $applicantEmail = $result['email'];
            $dateSubmitted = date('F j, Y', strtotime($result['date_submitted']));
            $timeSubmitted = date('h:i A', strtotime($result['time_submitted']));
            $admissionNumber = str_pad($result['admission_number'], 5, '0', STR_PAD_LEFT);
        } else {
            // No application found
            $admissionNumber = 'No application found';
            $applicantEmail = 'Not available';
            $dateSubmitted = 'Not available';
            $timeSubmitted = 'Not available';
        }
    } catch (PDOException $e) {
        // Error handling
        $admissionNumber = 'Error retrieving application';
        $applicantEmail = 'Not available';
        $dateSubmitted = 'Not available';
        $timeSubmitted = 'Not available';
    }
}

include '../components/php/header.php';
?>

<body>
<div class="main-content">
  <section>
    <div class="form-wrapper">
      <div class="form-container">
        <form>
          <div class="container">
            <table class="custom-table">
              <tbody>
                <tr>
                  <td class="document-logo">
                    <img src="../assets/images/document_logo.png" alt="Document Logo" class="document-img">
                    <p class="document-submit-date">Date Submitted: <?php echo htmlspecialchars($dateSubmitted); ?></p>
                    <p class="document-submit-time">Time Submitted: <?php echo htmlspecialchars($timeSubmitted); ?></p>
                  </td>
                  

                  <td class="text-box-td">
                    <p class="text-box">
                      Your Application <br>
                      Has Been <br>
                      Successfully Submitted <br>
                      To Our Registrar
                    </p>
                  </td>
              
                  <td class="admission-number-box">
                    <header>Admission<br>Number</header>
                    <p class="admission-number-text"><?php echo htmlspecialchars($admissionNumber); ?></p>
                  </td>
                </tr>
              </tbody>
            </table>
            <p class="reminder">Please check your registered email address (<?php echo htmlspecialchars($applicantEmail); ?>) for any updates</p>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<script src="../components/javascript/check_session_interval.js"></script>
<?php include '../components/php/modal_inactivity.php'; ?>
</body>
<?php include '../components/php/footer.php'; ?>
</html>

