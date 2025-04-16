if (!localStorage.getItem("first_logged_in_user")) {
    localStorage.setItem("first_logged_in_user", sessionStorage.getItem("user_id"));
}

document.addEventListener('DOMContentLoaded', () => {
    const autosaveFields = ['application_type', 'preferred_course'];
  
    autosaveFields.forEach(fieldName => {
      const input = document.querySelector(`[name="${fieldName}"]`);
      if (input) {
        input.addEventListener('change', () => {
          const value = input.value;
          fetch('../components/php/autosave.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `field=${encodeURIComponent(fieldName)}&value=${encodeURIComponent(value)}`
          })
          .then(response => response.json())
          .then(data => {
            console.log('Auto-saved:', data);
          })
          .catch(error => {
            console.error('Auto-save error:', error);
          });
        });
      }
    });
  });