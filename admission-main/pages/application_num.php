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
include '../components/php/script_application_num.php';
include '../components/php/header.php';
?>

<body>
<div class="main-content">
  <section>
      <div class="form-container">
        <form>
          <div class="container">
            <table class="custom-table">
              <tbody>
                <tr>
                  <td class="document-logo">
                    <img src="../assets/images/sent-docu-logo.png" alt="Document Logo" class="document-img">
                    <p class="document-submit-date">Date Submitted: <br><?php echo htmlspecialchars($dateSubmitted); ?></p>
                    <p class="document-submit-time">Time Submitted: <br><?php echo htmlspecialchars($timeSubmitted); ?></p>
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
  </section>
</div>

<script src="../components/javascript/check_session_interval.js"></script>
<?php include '../components/php/modal_inactivity.php'; ?>
</body>
<?php include '../components/php/footer.php'; ?>
</html>

