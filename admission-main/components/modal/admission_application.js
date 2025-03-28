function validateForm() {
    // Get the values of the required fields
    var applicationType = document.getElementById('applicationtype').value;
    var preferredCourse = document.getElementById('preferredcourse').value;
  
    // Check if both fields are filled
    if (applicationType && preferredCourse) {
      // Redirect to the next page if all requirements are met
      window.location.href = 'personal_info.html';
    } else {
      // Show an alert if any requirement is not met
      alert('Please select all the requirements.');
    }
  }
  