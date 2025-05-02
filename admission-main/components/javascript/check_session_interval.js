let isModalOpen = false;
let inactivityTime;
let warningTime = 29 * 60 * 1000;
let logoutTimer, warningTimer;
let flashInterval;
let originalTitle = document.title;
let countdownInterval;

let lastSessionRefresh = 0; // For throttling
const refreshThrottleTime = 5000; // 5 seconds
let skipNextDebounce = false; // Prevent debounce override after forced refresh

// Session check every 10 seconds
setInterval(() => {
    fetch('../components/php/check_session.php')
        .then(response => response.json())
        .then(data => {
            if (data.timeout) inactivityTime = data.timeout * 1000;
            if (!data.authenticated) window.location.href = '../components/php/logout.php';
        })
        .catch(err => console.error("Session check failed:", err));
}, 10000);

// Initial fetch to set inactivityTime
fetch('../components/php/check_session.php')
    .then(response => response.json())
    .then(data => {
        if (data.timeout) {
            inactivityTime = data.timeout * 1000;
            resetTimersShared();
        }
        if (!data.authenticated) window.location.href = '../components/php/logout.php';
    })
    .catch(err => console.error("Initial session check failed:", err));

function resetTimersShared(forceRefresh = false) {
    const now = Date.now();
    const shouldRefresh = forceRefresh || (!isModalOpen && (now - lastSessionRefresh > refreshThrottleTime));

    if (shouldRefresh) {
        lastSessionRefresh = now;
        localStorage.setItem('user-activity', now);
        localStorage.setItem('last-session-refresh', now);

        resetTimers();

        fetch('../components/php/refresh_session.php')
            .catch(err => console.error("Session refresh failed:", err));
    }
}

function resetTimers() {
    if (!inactivityTime) {
        console.warn("Inactivity time not set yet.");
        return;
    }

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
    localStorage.setItem('force-logout', Date.now());
    window.location.href = '../components/php/logout.php';
}

function showInactivityModal() {
    const modal = document.getElementById('inactivityModal');
    const countdownElement = document.getElementById('inactcountdown');
    const modalText = document.getElementById('modalText');
    const initialButtons = document.getElementById('initialButtons');
    const confirmButtons = document.getElementById('confirmLogoutButtons');

    if (!modal || !countdownElement || !modalText || !initialButtons || !confirmButtons) return;

    const remainingTime = Math.floor((inactivityTime - warningTime) / 1000);
    let countdown = remainingTime;
    const countdownStart = Date.now();

    modal.style.display = 'flex';
    isModalOpen = true;
    countdownElement.textContent = countdown;

    countdownInterval = setInterval(() => {
        const lastRefresh = localStorage.getItem('last-session-refresh');
        if (lastRefresh && parseInt(lastRefresh) > countdownStart) {
            clearInterval(countdownInterval);
            modal.style.display = 'none';
            stopAttentionGrabbers();
            resetTimers();
            isModalOpen = false;
            modalText.innerHTML = "You've been inactive for a while.<br>Do you want to stay logged in?";
            confirmButtons.style.display = 'none';
            initialButtons.style.display = 'flex';
            return;
        }

        countdown--;
        countdownElement.textContent = countdown;
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            logout();
        }
    }, 1000);

    const stayBtn = document.getElementById('stayLoggedInBtn');
    const logoutBtn = document.getElementById('logoutNowBtn');
    const confirmYesBtn = document.getElementById('confirmYesBtn');
    const confirmNoBtn = document.getElementById('confirmNoBtn');

    if (stayBtn) {
        stayBtn.onclick = () => {
            modal.style.display = 'none';
            clearInterval(countdownInterval);
            skipNextDebounce = true;
            resetTimersShared(true); // Force immediate session refresh
            stopAttentionGrabbers();
            localStorage.setItem('reset-from-modal', Date.now());
            isModalOpen = false;
            modalText.innerHTML = "You've been inactive for a while.<br>Do you want to stay logged in?";
            confirmButtons.style.display = 'none';
            initialButtons.style.display = 'flex';
        };
    }

    if (logoutBtn) {
        logoutBtn.onclick = () => {
            modalText.innerHTML = "Are you sure you want to log out?";
            initialButtons.style.display = 'none';
            confirmButtons.style.display = 'flex';
        };
    }

    if (confirmYesBtn) {
        confirmYesBtn.onclick = () => {
            clearInterval(countdownInterval);
            clearTimeout(warningTimer);
            clearTimeout(logoutTimer);
            stopAttentionGrabbers();
            logout();
        };
    }

    if (confirmNoBtn) {
        confirmNoBtn.onclick = () => {
            modalText.innerHTML = "You've been inactive for a while.<br>Do you want to stay logged in?";
            confirmButtons.style.display = 'none';
            initialButtons.style.display = 'flex';
        };
    }

    if (document.visibilityState !== 'visible') {
        startAttentionGrabbers();
    }
}

function startAttentionGrabbers() {
    if (flashInterval) clearInterval(flashInterval);
    flashInterval = setInterval(() => {
        document.title = (document.title === originalTitle) ? "⚠️ Inactivity Warning!" : originalTitle;
    }, 1000);
}

function stopAttentionGrabbers() {
    if (flashInterval) clearInterval(flashInterval);
    document.title = originalTitle;
}

let debounceTimer;
function debounceReset() {
    if (skipNextDebounce) {
        skipNextDebounce = false;
        return;
    }
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        resetTimersShared();
    }, 1000);
}

['click', 'mousemove', 'keydown', 'keyup', 'keypress', 'scroll', 'touchstart'].forEach(evt =>
    document.addEventListener(evt, debounceReset)
);

window.addEventListener('storage', (event) => {
    const modal = document.getElementById('inactivityModal');
    const modalText = document.getElementById('modalText');
    const confirmButtons = document.getElementById('confirmLogoutButtons');
    const initialButtons = document.getElementById('initialButtons');

    if (event.key === 'user-activity' || event.key === 'last-session-refresh') {
        resetTimers();
    }

    if (event.key === 'force-logout') {
        logout();
    }

    if (event.key === 'reset-from-modal') {
        if (modal && modalText && confirmButtons && initialButtons) {
            modal.style.display = 'none';
            clearInterval(countdownInterval);
            resetTimers();
            stopAttentionGrabbers();
            isModalOpen = false;
            modalText.innerHTML = "You've been inactive for a while.<br>Do you want to stay logged in?";
            confirmButtons.style.display = 'none';
            initialButtons.style.display = 'flex';
        }
    }
});
