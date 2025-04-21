document.addEventListener("DOMContentLoaded", function () {
    const emergencySelect = document.querySelector("select[name='emergency_complete_name_select']");
    const emergencyInput = document.getElementById("emergency-complete-name");
    const emergencyAddress = document.getElementById("emergency-complete-address");
    const emergencyContact = document.getElementById("emergency-contact");
    const emergencyEmail = document.getElementById("emergency-email");
    const emergencyTelephone = document.getElementById("emergency-telephone");

    const guardianAddress = document.getElementById("guardian-address");
    const guardianCity = document.getElementById("guardian-city");
    const guardianProvince = document.getElementById("guardian-province");
    const guardianBarangay = document.getElementById("guardian-barangay");
    const guardianEmail = document.getElementById("guardian-email");
    const guardianTelephone = document.getElementById("guardian-telephone");

    const personalAddress = sessionAddress;
    const personalBarangay = sessionBarangay;
    const personalCity = sessionCity;
    const personalProvince = sessionProvince;

    emergencySelect.style.color = "black";

    emergencySelect.addEventListener("change", function () {
        const selectedPerson = this.value;

        if (selectedPerson === "Father") {
            setEmergencyContact(
                document.getElementById("father-firstname").value,
                document.getElementById("father-middlename").value,
                document.getElementById("father-surname").value,
                combineAddress(personalAddress, personalBarangay, personalCity, personalProvince),
                document.getElementById("father-contact").value,
                "",
                ""
            );
        } else if (selectedPerson === "Mother") {
            setEmergencyContact(
                document.getElementById("mother-firstname").value,
                document.getElementById("mother-middlename").value,
                document.getElementById("mother-surname").value,
                combineAddress(personalAddress, personalBarangay, personalCity, personalProvince),
                document.getElementById("mother-contact").value,
                "",
                ""
            );
        } else if (selectedPerson === "Guardian") {
            setEmergencyContact(
                document.getElementById("guardian-firstname").value,
                document.getElementById("guardian-middlename").value,
                document.getElementById("guardian-surname").value,
                combineAddress(
                    guardianAddress.value,
                    guardianBarangay.options[guardianBarangay.selectedIndex]?.text || "",
                    guardianCity.options[guardianCity.selectedIndex]?.text || "",
                    guardianProvince.options[guardianProvince.selectedIndex]?.text || ""
                ),
                document.getElementById("guardian-contact").value,
                guardianEmail.value,
                guardianTelephone.value
            );
        } else if (selectedPerson === "None") {
            setEmergencyContact("N/A", "", "", "N/A", "N/A", "", "");
        } else {
            clearEmergencyContact();
        }

        emergencySelect.selectedIndex = 0;
        autosave();
    });

    [emergencyInput, emergencyAddress, emergencyContact, emergencyEmail, emergencyTelephone].forEach(input => {
        input.addEventListener("input", autosave);
    });

    function setEmergencyContact(firstName, middleName, lastName, address, contact, email, telephone) {
        emergencyInput.value = formatFullName(firstName, middleName, lastName);
        emergencyAddress.value = address;
        emergencyContact.value = contact;
        emergencyEmail.value = email;
        emergencyTelephone.value = telephone;
    }

    function clearEmergencyContact() {
        emergencyInput.value = "";
        emergencyAddress.value = "";
        emergencyContact.value = "";
        emergencyEmail.value = "";
        emergencyTelephone.value = "";
    }

    function combineAddress(address, barangay, city, province) {
        let full = address.trim();
        if (barangay) full += `, ${barangay}`;
        if (city) full += `, ${city}`;
        if (province) full += `, ${province}`;
        return full;
    }

    function formatFullName(firstName, middleName, lastName) {
        firstName = capitalizeFirstLetter(firstName);
        middleName = middleName && middleName !== "N/A" ? capitalizeFirstLetter(middleName) : "";
        lastName = capitalizeFirstLetter(lastName);
        return [firstName, middleName, lastName].filter(Boolean).join(" ");
    }

    function capitalizeFirstLetter(name) {
        return name && name !== "N/A" ? name.charAt(0).toUpperCase() + name.slice(1).toLowerCase() : name;
    }

    function autosave() {
        const data = {
            emergency_complete_name_select: emergencySelect.value,
            emergency_complete_name: emergencyInput.value,
            emergency_complete_address: emergencyAddress.value,
            emergency_contact: emergencyContact.value,
            emergency_email: emergencyEmail.value,
            emergency_telephone: emergencyTelephone.value
        };

        fetch('../components/php/save_emergency_contact.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Autosave failed.');
            }
        })
        .catch(error => {
            console.error('Autosave error:', error);
        });
    }
});

function capitalizeFirstLetter(input) {
    input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
}

document.querySelectorAll('input[type="text"]').forEach(function(input) {
    input.addEventListener('input', function() {
        capitalizeFirstLetter(this);
    });
});

function capitalizeWords(input) {
    input.value = input.value.replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });
}
