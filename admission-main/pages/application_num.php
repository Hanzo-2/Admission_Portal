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
include '../components/php/header.php'; 
?>

<body>
    <div class="container">
        <main class="main-content">
            <div class="message-box">
                <p class="success-message">Your Application Has Been Successfully Sent To Our Registrar.</p>
            </div>
            <div class="admission-number-box">
                <header>Your Admission Number</header>
                <p class="copy-text" id="admissionNumber">00001</p>
            </div>
        </main>
    </div>
<script src="../components/javascript/check_session_interval.js"></script>
<?php include '../components/php/modal_inactivity.php'; ?>   
</body>
<?php include '../components/php/footer.php'; ?>
</html>
