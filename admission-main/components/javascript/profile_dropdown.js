function toggleProfileDropdown() {
    const dropdown = document.getElementById("profile-dropdown");

    if (dropdown.classList.contains("show")) {
        dropdown.classList.remove("fade-in");
        dropdown.classList.add("fade-out");

        setTimeout(() => {
            dropdown.classList.remove("show", "fade-out");
        }, 200); // Matches animation duration
    } else {
        dropdown.classList.add("show", "fade-in");
    }
}

window.onclick = function(event) {
    const dropdown = document.getElementById("profile-dropdown");
    const profileIcon = document.getElementById("profile-pic");

    if (!profileIcon.contains(event.target) && !dropdown.contains(event.target)) {
        if (dropdown.classList.contains("show")) {
            dropdown.classList.remove("fade-in");
            dropdown.classList.add("fade-out");

            setTimeout(() => {
                dropdown.classList.remove("show", "fade-out");
            }, 200);
        }
    }
};
