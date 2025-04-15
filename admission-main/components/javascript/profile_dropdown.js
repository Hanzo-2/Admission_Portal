function toggleProfileDropdown() {
    document.getElementById("profile-dropdown").classList.toggle("show");
  }
  window.onclick = function(event) {
    if (!event.target.matches('.profile-icon')) {
      var dropdowns = document.getElementsByClassName("profile-dropdown");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }