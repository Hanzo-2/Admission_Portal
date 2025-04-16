setInterval(function () {
    fetch('../components/php/check_session.php')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                alert("You have been logged out.");
                window.location.href = 'http://localhost/admission_portal/admission-main/index.php'; // Redirect to login page
            }
        });
}, 3000); // Check every 3 seconds
