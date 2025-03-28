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
function formatPhoneNumber(input) {
    // Remove all non-numeric characters
    let value = input.value.replace(/\D/g, "");

    // Limit to 11 digits
    if (value.length > 11) {
        value = value.substring(0, 11);
    }

    // Apply formatting: 1234-567-8901 (handles partial inputs correctly)
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
        formattedValue = value; // If less than 4 digits, keep as is
    }

    // Update input value
    input.value = formattedValue;
}
// For Contact Number end

// Function to format telephone number as XX-XXXX-XXXX - start
function formatTelephone(input) {
    // Remove all non-numeric characters
    let value = input.value.replace(/\D/g, "");

    // Limit to 10 digits
    if (value.length > 10) {
        value = value.substring(0, 10);
    }

    // Apply formatting: XX-XXXX-XXXX (handles partial inputs correctly)
    let formattedValue = "";
    if (value.length > 2) {
        formattedValue = value.substring(0, 2) + "-";
        if (value.length > 6) {
            formattedValue += value.substring(2, 6) + "-";
            formattedValue += value.substring(6);
        } else {
            formattedValue += value.substring(2);
        }
    } else {
        formattedValue = value; // If less than 2 digits, keep as is
    }

    // Update input value
    input.value = formattedValue;
}
// Function to format telephone number as XX-XXXX-XXXX - end

function goBack() {
    window.location.href = 'admission_application.html';
}

function validateForm() {
    let form = document.querySelector("form");
    let requiredFields = form.querySelectorAll("[required]");
    let isValid = true;

    requiredFields.forEach(function (field) {
        if (!field.value) {
            isValid = false;
            field.reportValidity(); // Show alert like "required" fields
        }
    });

    if (isValid) {
        window.location.href = 'family_info.html'; // Redirect to the next page
    }
}

function goBack() {
    window.location.href = 'admission_application.html';
}
