<?php
if (!isset($_SESSION['google_id'])) {
    header("Location: ../index.php");
    exit();
} //checks whether the user is logged in or has log out, will redirect user to login page when not authorized

if (isset($_SESSION['user'])) {
    $username = htmlspecialchars($_SESSION['user']['name'] ?? 'Guest', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_SESSION['user']['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $profile_picture = $_SESSION['user']['profile_picture'] ?? '../assets/images/Profile-icon-placeholder.png'; // ← no htmlspecialchars here
} else {
    $username = 'Guest';
    $email = '';
    $profile_picture = '../assets/images/Profile-icon-placeholder.png';
}

?>
<body>
    <header>
        <div class="header-content">
            <div class="branding">
                <img src="../assets/images/spistlogo.png" alt="SPIST Logo">
                <p>SPIST Admission Portal</p>
            </div>

            <div class="profile-container">
                <img id="profile-pic" class="profile-icon" src="<?= htmlspecialchars($profile_picture, ENT_QUOTES, 'UTF-8') ?>" alt="User Profile Icon"
                    onerror="this.src='../assets/images/Profile-icon-placeholder.png';" loading="lazy" onclick="toggleProfileDropdown()">

                <div class="profile-dropdown" id="profile-dropdown">
                    <p id="username"><?= $username ?></p>
                    <p><?= $email ?: 'No email available' ?></p>
                    <button id="logout-button">Log out</button>
                </div>
            </div>
        </div>
    </header>

    <div id="logoutConfirmModal" class="modal-overlay">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <div class="modal-buttons">
                <button id="cancelLogoutBtn">Keep Me Logged In</button>
                <button id="confirmLogoutBtn">Log Me Out</button>
            </div>
        </div>
    </div>

</body>

<script>
document.getElementById("logout-button").addEventListener("click", function () {
    document.getElementById("logoutConfirmModal").style.display = "flex";
});

document.getElementById("cancelLogoutBtn").addEventListener("click", function () {
    document.getElementById("logoutConfirmModal").style.display = "none";
});

document.getElementById("confirmLogoutBtn").addEventListener("click", function () {
    window.location.href = "../components/php/logout.php";
});
</script>

<style>
a {
    text-decoration: none;
}

header {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    padding: 5px;
    background: #43b14b;
    border-bottom: 8px solid #ffde59;
    flex-wrap: wrap;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between; 
    width: 100%;
    font-weight: bolder;
}

.header-content img {
    width: clamp(80px, 12vw, 120px);
    height: clamp(80px, 12vw, 120px);
    padding: clamp(10px, 4vw, 15px);
}

.branding {
    display: flex;
    align-items: center;
}

.branding p {
    font-size: clamp(16.5px, 4vw, 60px);
}

.branding img {
    border-radius: 100%;
}

.profile-container {
    position: relative; 
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.profile-icon {
    cursor: pointer;
    border-radius: 100%;
}

.profile-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 5px;
    color: #ffffff;
    font-weight: bold;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.9);
    background-color: rgba(67, 177, 75, 0.98);
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    padding: 10px;
    border: 3px solid black;
    border-radius: 5px;
    min-width: 300px;
    text-align: center;
    z-index: 1000;
}

#username {
    margin-top: 25px;
}

.profile-dropdown.show {
    opacity: 1;
    pointer-events: auto;
    transform: translateY(0);
    display: block;
}

.profile-dropdown p {
    margin: 5px 0;
    font-size: clamp(14px, 2vw, 17px);
    padding: 0 20px;
    color: white;
    font-weight: bold;
}

.profile-dropdown button {
    background-color: #212121;
    color: white;
    border: none;
    margin: 20px auto;
    padding: 10px;
    width: 70%;
    cursor: pointer;
    border-radius: 5px;
    font-size: clamp(14px, 2vw, 17px);
    display: block;
    text-align: center;
}

#logout-button {
    transition: transform 0.2s ease;
}

#logout-button:hover {
    transform: scale(1.05);
    color: #FF073A;
}

header p {
    color: #ffde59;
    font-family: Georgia, serif;
}

#logoutConfirmModal.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1001;
    justify-content: center;
    align-items: center;
}

#logoutConfirmModal .modal-content {
    background: rgba(255, 255, 225, 1);
    border: 4px solid #FF073A;
    border-radius: 10px;
    padding: clamp(20px, 5vw, 40px);
    max-width: 500px;
    width: 90%;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    animation: modalFadeIn 0.3s ease-out;
}

#logoutConfirmModal .modal-content p {
    font-size: clamp(24px, 9vw, 40px);
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
}

#logoutConfirmModal p {
    font-size: 20px;
    font-weight: bold;
}

#logoutConfirmModal .modal-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

#logoutConfirmModal .modal-buttons button {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    width: 48%; /* Ensures the buttons take up nearly half of the modal's width */
}

.modal-buttons {
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
    width: 100%;
}

.modal-buttons button {
    flex: 1 1 45%;
    padding: clamp(10px, 2vw, 14px);
    font-size: clamp(14px, 2vw, 18px);
    border-radius: 6px;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.modal-buttons button:hover {
    transform: scale(1.05);
}

.modal-buttons button:active {
    transform: scale(0.95);
}

#confirmLogoutBtn {
    background-color: #f44336;
    border: 2px solid darkred;
    font-weight: bold;
    color: white;
}

#cancelLogoutBtn {
    background-color: #4CAF50;
    border: 2px solid darkgreen;
    font-weight: bold;
    color: white;
}

#cancelLogoutBtn:hover, #confirmLogoutBtn:hover {
    color: black;
}

.fade-in {
    animation: dropdownFadeIn 0.2s ease forwards;
}

.fade-out {
    animation: dropdownFadeOut 0.2s ease forwards;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes dropdownFadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes dropdownFadeOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-10px); }
}
</style>
