document.addEventListener('DOMContentLoaded', () => {
    const autosaveFields = [
      'application_type', 'preferred_course',
      'personal_firstname', 'personal_middlename', 'personal_surname',
      'personal_birthdate', 'birthplace', 'sex', 'civilstatus',
      'nationality', 'religion', 'address',
      'selected_province', 'selected_city', 'selected_barangay',
      'personal_contact', 'personal_email', 'telephone', 'lrn_num', 'school_type',
      'student_type', 'school_name', 'school_address', 'track_strand', 'year_graduation',
      'shs_average'
    ];
  
    autosaveFields.forEach(fieldName => {
      const input = document.querySelector(`[name="${fieldName}"]`);
      if (input) {
        // Use 'input' event for all fields for real-time autosaving
        input.addEventListener('input', saveField);
      }
    });

    function saveField(event) {
    const fieldName = event.target.name;
    const value = event.target.value;

    if (fieldName === 'personal_email') {
      // Run validation
      const atIndex = value.indexOf('@');
      const domainPart = value.substring(atIndex + 1);
      const isValid = atIndex > 0 && domainPart.includes('.');

      if (!isValid && value !== "") {
        console.log("Invalid email, not saving.");
        return; // Block invalid email from being saved
      }
    }

    // Continue with autosave
    fetch('../components/php/autosave.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `field=${encodeURIComponent(fieldName)}&value=${encodeURIComponent(value)}`
    })
    .then(response => response.json())
    .then(data => {
      console.log(`Auto-saved ${fieldName}:`, data);
    })
    .catch(error => {
      console.error('Auto-save error:', error);
    });
    }

});
