setInterval(function () {
    fetch('../components/php/check_session.php')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                window.location.href = 'http://localhost/admission_portal/admission-main/components/php/logout.php';
            }
        });
}, 5000); // Check every 5 seconds

let inactivityTime = 30 * 60 * 1000; // Change to 30 * 60 * 1000 for 30 mins
let warningTime = 29 * 60 * 1000;     // Change to 29 * 60 * 1000 for 29 mins
let logoutTimer, warningTimer;
let flashInterval;
let originalTitle = document.title;

// Shared reset activity across tabs
function resetTimersShared() {
    localStorage.setItem('user-activity', Date.now()); // Broadcast to other tabs
    resetTimers();
}

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

// Logout and broadcast to other tabs
function logout() {
    localStorage.setItem('force-logout', Date.now()); // Force logout all tabs
    window.location.href = 'http://localhost/admission_portal/admission-main/components/php/logout.php';
}

let countdownInterval;
// Handle modal and visual warnings
function showInactivityModal() {
    const modal = document.getElementById('inactivityModal');
    const countdownElement = document.getElementById('countdown');

    const remainingTime = Math.floor((inactivityTime - warningTime) / 1000); // dynamically calculate countdown
    let countdown = remainingTime;

    if (modal) modal.style.display = 'flex';
    if (countdownElement) countdownElement.textContent = countdown;

    countdownInterval = setInterval(() => {
        countdown--;
        if (countdownElement) countdownElement.textContent = countdown;
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            logout(); // Auto logout if time runs out
        }
    }, 1000);

    const stayBtn = document.getElementById('stayLoggedInBtn');
    const logoutBtn = document.getElementById('logoutNowBtn');

    if (stayBtn && logoutBtn) {
        stayBtn.onclick = () => {
            if (modal) modal.style.display = 'none';
            clearInterval(countdownInterval);
            resetTimersShared();
            stopAttentionGrabbers();
            localStorage.setItem('reset-from-modal', Date.now());
        };

        logoutBtn.onclick = () => {
            clearInterval(countdownInterval);
            logout();
            stopAttentionGrabbers();
        };
    }

    if (document.visibilityState !== 'visible') {
        startAttentionGrabbers();
    }
}

function startAttentionGrabbers() {
    flashInterval = setInterval(() => {
        document.title = (document.title === originalTitle) ? "⚠️ Inactivity Warning!" : originalTitle;
    }, 1000);
}

function stopAttentionGrabbers() {
    clearInterval(flashInterval);
    document.title = originalTitle;
}

// Listen to user activity
['click', 'mousemove', 'keydown', 'keyup', 'keypress', 'scroll', 'touchstart'].forEach(evt =>
    document.addEventListener(evt, resetTimersShared)
);

// Handle events from other tabs
window.addEventListener('storage', (event) => {
    if (event.key === 'user-activity') {
        resetTimers(); // Sync activity
    }

    if (event.key === 'force-logout') {
        logout(); // Sync logout
    }

    if (event.key === 'reset-from-modal') {
        const modal = document.getElementById('inactivityModal');
        if (modal) modal.style.display = 'none';
        clearInterval(countdownInterval);
        resetTimers();
        stopAttentionGrabbers();
    }
});


// Initialize timers on load
window.onload = resetTimersShared;
