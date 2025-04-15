setInterval(function () {
    fetch('../components/php/check_session.php')
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                alert("You have been logged out.");
                window.location.href = '../index.php'; // Redirect to login page
            }
        });
}, 5000); // Check every 5 seconds