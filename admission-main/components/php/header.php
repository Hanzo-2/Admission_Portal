<?php
if (!isset($_SESSION['google_id'])) {
    header("Location: http://localhost/admission_portal/admission-main/index.php");
    exit();
} //checks whether the user is logged in or has log out, will redirect user to login page when not authorized

if (isset($_SESSION['user'])) {
    $username = htmlspecialchars($_SESSION['user']['name'] ?? 'Guest', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_SESSION['user']['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $profile_picture = htmlspecialchars($_SESSION['user']['profile_picture'] ?? '../assets/images/Profile-icon-placeholder.png', ENT_QUOTES, 'UTF-8');
} else {
    $username = 'Guest';
    $email = '';
    $profile_picture = '../assets/images/Profile-icon-placeholder.png';
}
?>
<body>
    <header>
        <div class="header-content">    
          <img src="../assets/images/spistlogo.png" alt="SPIST Logo">
          <p>SPIST Admission Portal</p>
        </div>
        <div class="profile-container">
            <img id="profile-pic" class="profile-icon" alt="User Profile Icon" loading="lazy" onclick="toggleProfileDropdown()">
                <script>
                    const profilePic = document.getElementById("profile-pic");
                    profilePic.src = "<?php echo isset($_SESSION['user']['profile_picture']) ? $_SESSION['user']['profile_picture'] : '../assets/images/Profile-icon-placeholder.png'; ?>";
                    profilePic.onerror = function() {
                    this.src = '../assets/images/Profile-icon-placeholder.png';
                    };
                </script>
            <div class="profile-dropdown" id="profile-dropdown">
                <p id="username" name="username">
                    <?php echo isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Guest'; ?>
                </p>
                <p name="email">
                    <?php echo isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : 'No email available'; ?>
                </p>
                <a style="text-decoration: none" href="../components/php/logout.php"><button id="logout-button">Log out</button></a>
            </div>
        </div>
      </header> 
</body>
<style>
    header {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    padding: 2px 10px; 
    background: #43b14b;
    border-bottom: 8px solid #ffde59;
}

.header-content {
    display: flex;
    align-items: center;
    font-weight: bolder;
}

.profile-container {
    position: initial;
    margin-left: auto;
    margin-right: 21px;
}

.profile-icon {
    width: 115px;
    height: 100px;
    cursor: pointer;
    border-radius: 100%;
}

.profile-dropdown {
    color: #ffffff; 
    font-weight: bold;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.9); 
    display: none;
    position: absolute;
    right: 0;
    background-color: rgba(67, 177, 75, 0.98);
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    padding: 10px;
    border: 3px solid black;
    border-radius: 5px;
    min-width: 180px;
    text-align: center;
    z-index: 1000;
}

#username{
    margin-top: 30px;
}

.profile-dropdown.show {
    display: block;
}

.profile-dropdown p {
    margin: 5px 0;
    font-size: 17px;
    padding-left: 30px;
    padding-right: 30px;
    color: white;
    font-weight: bold;
}

.profile-dropdown button {
    background-color: #212121;
    color: white;
    border: none;
    margin: 20px auto; /* Centers the button */
    padding: 10px; /* Adjust padding for better appearance */
    width: 70%; /* Adjust width to be more proportional */
    cursor: pointer;
    border-radius: 5px;
    font-size: 17px;
    display: block; /* Ensures proper centering */
    text-align: center;
}

#logout-button:hover {
    color: #FF073A;
}

header img {
    width: 100px;
    padding: 10px;
    margin-right: 12px; 
}

header p {
    color: #ffde59;
    font-size: 40px; 
    font-family: Georgia, serif;
}
</style>
