setInterval(function () {
    fetch('../components/php/check_session.php')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                alert("You have been logged out.");
                window.location.href = 'http://localhost/admission_portal/admission-main/components/php/logout.php'; // Redirect to login page
            }
        });
}, 5000); // Check every 5 seconds

let inactivityTime = 45 * 60 * 1000; // 45 x 60 x 1000 milliseconds = 2,700,000 / 60000 or 1 second = 45 minutes
let warningTime = 44 * 60 * 1000; // 44 minutes
let logoutTimer, warningTimer;

function resetTimers() {
    clearTimeout(logoutTimer);
    clearTimeout(warningTimer);

    warningTimer = setTimeout(() => {
        showInactivityModal();
    }, warningTime);    

    logoutTimer = setTimeout(() => {
        logout();
    }, inactivityTime);
}

function logout() {
    alert("Logged Out due to Inactivity.");
    window.location.href = 'http://localhost/admission_portal/admission-main/components/php/logout.php';
}

window.onload = resetTimers;
['click', 'mousemove', 'keydown', 'keyup', 'keypress', 'scroll', 'touchstart'].forEach(evt =>
    document.addEventListener(evt, resetTimers)
);


function showInactivityModal() {
    const modal = document.getElementById('inactivityModal');
    modal.style.display = 'flex';

    document.getElementById('stayLoggedInBtn').onclick = () => {
        modal.style.display = 'none';
        resetTimers();
        stopAttentionGrabbers();
    };

    document.getElementById('logoutNowBtn').onclick = () => {
        logout();
        stopAttentionGrabbers();
    };

    // Start attention-grabbing methods if tab is inactive
    if (document.visibilityState !== 'visible') {
        startAttentionGrabbers();
    }
}

let flashInterval;
let originalTitle = document.title;

function startAttentionGrabbers() {
    flashInterval = setInterval(() => {
        document.title = (document.title === originalTitle) ? "⚠️ Inactivity Warning!" : originalTitle;
    }, 1000);
}

function stopAttentionGrabbers() {
    clearInterval(flashInterval);
    document.title = originalTitle;
}
