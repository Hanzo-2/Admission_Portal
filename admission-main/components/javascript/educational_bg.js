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
        let raw = this.value.replace(/[^0-9]/g, ""); // Keep only digits
        // Allow backspacing by checking if the input is empty
        if (raw === "") {
            this.value = "";
            return;
        }
        // If the first digit exists and is less than 6, replace it with 6
        if (raw.length >= 1 && parseInt(raw.charAt(0)) < 6) {
            raw = "6" + raw.slice(1);
        }
        // Automatically insert a decimal after the first two digits
        if (raw.length > 2) {
            raw = raw.slice(0, 2) + "." + raw.slice(2, 4); // e.g., 7512 => 75.12
        }
        // Limit to 5 characters (including the decimal point)
        if (raw.length > 5) {
            raw = raw.slice(0, 5);
        }
        this.value = raw;
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