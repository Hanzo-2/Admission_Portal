document.addEventListener('DOMContentLoaded', () => {
    const autosaveFields = [
      'application_type', 'preferred_course',
      'personal_firstname', 'personal_middlename', 'personal_surname',
      'personal_birthdate', 'birthplace', 'sex', 'civilstatus',
      'nationality', 'religion', 'address',
      'selected_province', 'selected_city', 'selected_barangay',
      'personal_contact', 'personal_email', 'telephone', 'lrn_num', 'school_type',
      'student_type', 'school_name', 'school_address', 'track_strand', 'year_graduation',
      'shs_average', 'father_firstname', 'father_middlename', 'father_surname', 'father_birthdate',
      'father_contact', 'mother_firstname', 'mother_middlename', 'mother_surname', 'mother_birthdate',
      'mother_contact', 'guardian_firstname', 'guardian_middlename', 'guardian_surname',
      'guardian_address', 'guardian_province', 'guardian_city', 'guardian_barangay', 'guardian_contact', 'guardian_email',
      'guardian_telephone', 'emergency_complete_name', 'emergency_complete_name_select','emergency_complete_address', 'emergency_contact',
      'emergency_email', 'emergency_telephone'
    ];
  
    autosaveFields.forEach(fieldName => {
      const inputs = document.querySelectorAll(`[name="${fieldName}"]`);
      inputs.forEach(input => {
        if (input.type === 'radio') {
          input.addEventListener('change', saveField);
        } else {
          input.addEventListener('input', saveField);
        }
      });
    });

    document.querySelectorAll('input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', saveField);
    });

    function saveField(event) {
      const fieldName = event.target.name;
      let value = event.target.value; // Make this mutable
    
      // Email validation
      if (fieldName === 'personal_email') {
        const atIndex = value.indexOf('@');
        const domainPart = value.substring(atIndex + 1);
        const isValid = atIndex > 0 && domainPart.includes('.');
        if (!isValid && value !== "") {
          value = ""; // Clear it
        }
      }
    
      // Mobile number validation (11 digits only)
      if (['personal_contact', 'father_contact', 'mother_contact'].includes(fieldName)) {
        const digitsOnly = value.replace(/\D/g, '');
        if (digitsOnly.length !== 11) {
            value = ""; // Clear it
        }
      }
    
      // Telephone number validation (9 digits only)
      if (fieldName === 'telephone') {
        const digitsOnly = value.replace(/\D/g, '');
        if (digitsOnly.length !== 9) {
          value = ""; // Clear it
        }
      }



      // Continue with autosave (value might be empty if invalid)
      fetch('../components/php/autosave.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
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
