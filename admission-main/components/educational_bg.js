document.addEventListener("DOMContentLoaded", function () {
    const lrnInput = document.getElementById("lrn");
    lrnInput.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
        if (this.value.length > 12) {
            this.value = this.value.slice(0, 12); // Limit input to 12 digits
        }
    });

    const shsAverageInput = document.getElementById("shs-average");
    shsAverageInput.addEventListener("input", function () {
        let value = this.value.replace(/[^0-9]/g, ""); // Allow only numbers, remove everything else
        
        // Automatically insert the decimal point after two digits
        if (value.length > 2) {
            value = value.slice(0, 2) + "." + value.slice(2, 4); // Insert decimal after 2 digits
        }
    
        // Ensure the value does not exceed 5 characters (100.00 is the maximum)
        if (value.length > 5) {
            value = value.slice(0, 5); // Limit to 5 characters (including the period)
        }
    
        // Set the formatted value back to the input
        this.value = value;
    });
});

document.getElementById("year-graduation").addEventListener("input", function () {
    let value = this.value.replace(/[^0-9]/g, ""); // Remove non-numeric characters

    // Enforce the first digit rule (must be 1 or 2)
    if (value.length >= 1) {
        if (value[0] !== "1" && value[0] !== "2") {
            value = "2"; // Auto-correct to 2 if user enters 3-9
        }
    }

    // Enforce the second digit rules
    if (value.length >= 2) {
        if (value[0] === "2" && value[1] !== "0") {
            value = value[0] + "0"; // Auto-correct to "20" if first digit is 2
        } else if (value[0] === "1" && value[1] < "9") {
            value = value[0] + "9"; // Auto-correct to "19" if first digit is 1 and second digit is below 9
        }
    }

    // Limit input to 4 digits
    if (value.length > 4) {
        value = value.slice(0, 4);
    }

    this.value = value;
});