//For Date of Birth start
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
//For Date of Birth end

//For Contact Number start
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
//For Contact Number end

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

//For Pick from list - start
document.addEventListener("DOMContentLoaded", function () {
    const emergencySelect = document.querySelector("select[name='complete_name_select']");
    const emergencyInput = document.querySelector("input[name='complete_name']");
    const emergencyAddress = document.querySelector("input[name='complete_address']");
    const emergencyContact = document.querySelector("input[name='emergency_contact']");
    const emergencyEmail = document.querySelector("input[name='emergency_email']");
    const emergencyTelephone = document.querySelector("input[name='emergency_telephone']");

    const guardianAddress = document.querySelector("input[name='guardian_address']");
    const guardianCity = document.querySelector("select[name='guardian_city']");
    const guardianProvince = document.querySelector("select[name='guardian_province']");
    const guardianEmail = document.querySelector("input[name='guardian_email']");
    const guardianTelephone = document.querySelector("input[name='guardian_telephone']");

    // Set the dropdown color to grey
    emergencySelect.style.color = "grey";

    // Change color back to default when user selects an option
    emergencySelect.addEventListener("change", function () {
        this.style.color = "black"; // Change text color when an option is selected
    });

    // Event listener for dropdown selection
    emergencySelect.addEventListener("change", function () {
        let selectedPerson = this.value;

        if (selectedPerson === "Father") {
            setEmergencyContact(
                document.getElementById("father-firstname").value,
                document.getElementById("father-middlename").value,
                document.getElementById("father-surname").value,
                "", // No address for Father
                document.getElementById("father-contact").value,
                "", // No email for Father
                ""  // No telephone for Father
            );
        } else if (selectedPerson === "Mother") {
            setEmergencyContact(
                document.getElementById("mother-firstname").value,
                document.getElementById("mother-middlename").value,
                document.getElementById("mother-surname").value,
                "", // No address for Mother
                document.getElementById("mother-contact").value,
                "", // No email for Mother
                ""  // No telephone for Mother
            );
        } else if (selectedPerson === "Guardian") {
            setEmergencyContact(
                document.getElementById("guardian-firstname").value,
                document.getElementById("guardian-middlename").value,
                document.getElementById("guardian-surname").value,
                combineAddress(guardianAddress.value, guardianCity.value, guardianProvince.value),
                document.getElementById("guardian-contact").value,
                guardianEmail.value, // Take email from Guardian
                guardianTelephone.value // Take telephone from Guardian
            );
        } else if (selectedPerson === "None") {
            setEmergencyContact("N/A", "", "", "N/A", "N/A", "", "");
        } else {
            clearEmergencyContact();
        }

        // Reset dropdown to "Pick from list" while keeping functionality
        this.selectedIndex = 0;
        this.style.color = "grey"; // Reset color to grey after selection
    });

    // Function to update emergency contact fields
    function setEmergencyContact(firstName, middleName, lastName, address, contact, email, telephone) {
        emergencyInput.value = formatFullName(firstName, middleName, lastName);
        emergencyAddress.value = address;
        emergencyContact.value = contact;
        emergencyEmail.value = email;
        emergencyTelephone.value = telephone;
    }

    // Function to clear emergency contact fields
    function clearEmergencyContact() {
        emergencyInput.value = "";
        emergencyAddress.value = "";
        emergencyContact.value = "";
        emergencyEmail.value = "";
        emergencyTelephone.value = "";
    }

    // Function to format guardian address (City before Province)
    function combineAddress(address, city, province) {
        let fullAddress = address.trim();
        if (city) fullAddress += `, ${city}`;
        if (province) fullAddress += `, ${province}`;
        return fullAddress;
    }

    // Function to format full name
    function formatFullName(firstName, middleName, lastName) {
        firstName = capitalizeFirstLetter(firstName);
        middleName = middleName && middleName !== "N/A" ? capitalizeFirstLetter(middleName).charAt(0) + "." : middleName;
        lastName = capitalizeFirstLetter(lastName);
        return [firstName, middleName, lastName].filter(Boolean).join(" ");
    }

    // Function to capitalize first letter of names
    function capitalizeFirstLetter(name) {
        return name && name !== "N/A" ? name.charAt(0).toUpperCase() + name.slice(1).toLowerCase() : name;
    }
});

//For Pick from list - end
