document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('input[type="date"]').forEach(function (dateInput) {
        let form = dateInput.closest("form"); // Find the closest form containing the input

        function updateColor() {
            dateInput.style.color = dateInput.value ? "black" : "grey";
        }

        // Set initial color
        updateColor();

        // When user clicks the field, set text to black
        dateInput.addEventListener("focus", function () {
            this.style.color = "black";
        });

        // When input is removed, update color
        dateInput.addEventListener("input", function () {
            updateColor();
        });

        // When user leaves the field
        dateInput.addEventListener("blur", function () {
            updateColor();
        });

        // Validate on form submission
        if (form) {
            form.addEventListener("submit", function (event) {
                let minYear = 1900;
                let maxYear = 2099;
                let dateParts = dateInput.value.split("-"); // Format: YYYY-MM-DD

                if (dateInput.value) { // If there's input
                    let year = parseInt(dateParts[0]);

                    if (isNaN(year) || year < minYear || year > maxYear) {
                        dateInput.setCustomValidity(`Year must be between ${minYear} and ${maxYear}.`);
                        event.preventDefault(); // Prevent form submission
                    } else {
                        dateInput.setCustomValidity(""); // Reset error
                    }
                } else {
                    dateInput.setCustomValidity(""); // Allow empty input
                }

                dateInput.reportValidity(); // Show alert like "required" fields
            });
        }
    });
});

// For Contact Number start
function formatvalidatePhoneNumber(input) {
    let value = input.value.trim().replace(/\D/g, "");

    // Auto-correct prefix if needed
    if (value.length >= 2) {
        if (value.substring(0, 2) !== '09') {
            value = '09' + value.replace(/^0*/, '').replace(/^9*/, '');
        }
    } else if (value.length === 1) {
        if (value !== '0') {
            value = '09';
        }
    }

    // Limit to 11 digits
    if (value.length > 11) {
        value = value.substring(0, 11);
    }

    // Apply formatting (XXXX-XXX-XXXX)
    let formattedValue = "";
    if (value.length > 4) {
        formattedValue = value.substring(0, 4) + "-";
        if (value.length > 7) {
            formattedValue += value.substring(4, 7) + "-";
            formattedValue += value.substring(7);
        } else {
            formattedValue += value.substring(4);
        }
    } else {
        formattedValue = value;
    }

    // Set formatted value to the input field
    input.value = formattedValue;

    // Validation: Check if exactly 11 digits (without dashes)
    let isValid = value.length === 11;

    // Set border color based on validity
    if (value === "") {
        input.style.borderColor = ""; // Default
    } else if (isValid) {
        input.style.borderColor = "green"; // Valid
    } else {
        input.style.borderColor = "red"; // Invalid
    }

    // Set native form validation message
    if (!isValid) {
        input.setCustomValidity("Phone number must be exactly 11 digits.");
    } else {
        input.setCustomValidity("");
    }
}
// For Contact Number end

// Function to format telephone number as XX-XXXX-XXXX - start
function formatvalidateTelephone(input) {
    // Get only digits
    let digits = input.value.replace(/\D/g, "");

    // Limit to 9 digits max
    digits = digits.substring(0, 9);

    // Apply formatting (XX)-XXX-YYYY
    let formatted = "";
    if (digits.length > 0) {
        formatted += "(" + digits.substring(0, 2) + ")";
    }
    if (digits.length > 2) {
        formatted += "-" + digits.substring(2, 5);
    }
    if (digits.length > 5) {
        formatted += "-" + digits.substring(5);
    }

    if (digits.length < 3) {
        formatted = digits; // Skip formatting if too short
    }

    // Update input value
    input.value = formatted;

    // Validation logic
    const isFilled = digits.length > 0;
    const isValid = digits.length === 9;

    if (!isFilled) {
        input.style.borderColor = ""; // Default style
        input.setCustomValidity("");  // No error
    } else if (isValid) {
        input.style.borderColor = "green";
        input.setCustomValidity("");  // Valid input
    } else {
        input.style.borderColor = "red";
        input.setCustomValidity("Telephone number must be 9 digits.");
    }
}
// Function to format telephone number as XX-XXXX-XXXX - end

function validateEmail(input){
    let value = input.value.trim();
    
    // Basic validation: check if it has @ and at least one . after @
    let atIndex = value.indexOf('@');
    let isValid = false;

    if (atIndex > 0) { // Make sure @ is not the first character
        let domainPart = value.substring(atIndex + 1);
        if (domainPart.includes('.')) {
            isValid = true;
        }
    }

    // Set border color based on validity
    if (value === "") {
        input.style.borderColor = ""; // Default if empty (optional)
    } else if (isValid) {
        input.style.borderColor = "green"; // Valid email
    } else {
        input.style.borderColor = "red"; // Invalid email
    }
}
