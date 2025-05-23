<!DOCTYPE html>
<html lang="en">
<head>
  <title>SPIST Admission Portal</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="assets/styles/index_style.css">
  <link rel="icon" href="assets/images/spistlogo_icon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php
session_start();
if (isset($_SESSION["google_id"])) {
    header("Location: ../admission-main/pages/admission_application.php");
}
require __DIR__ . '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$client = new Google\Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
$client->addScope("email");
$client->addScope("profile");
$client->setPrompt('login');
$client->setPrompt('consent select_account');
$authUrl = htmlspecialchars($client->createAuthUrl() . '&hl=en');
?>

<body>
  <form class="form">
    <img src="assets/images/spistlogo.png" class="fit-picture" alt="SPIST-logo">
    <p><span class="spist">SPIST</span><br>Admission Portal</p>

    <a href="<?= $authUrl ?>" style="text-decoration: none;" class="oauthButton">
        <svg class="icon" viewBox="0 0 24 24">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
            <path d="M1 1h22v22H1z" fill="none"></path>
        </svg>
        Continue with Google
    </a>
  </form>
</body>

</html>
