//Upload files while also cheking - start
function uploadFile(input, rowId) {
    let file = input.files[0]; // Get the selected file

    if (file) {
        let allowedExtensions = ["image/png", "image/jpeg", "image/jpg", "application/pdf"];
        let maxSize = 1024 * 1024; // 1MB in bytes

        if (!allowedExtensions.includes(file.type)) {
            showToast("Only PNG, JPG, JPEG, and PDF files are allowed.", "error");
            input.value = ""; // Reset the file input
            return;
        }

        if (file.size > maxSize) {
            showToast("File size exceeds 1MB. Please upload a smaller file.", "error");
            input.value = ""; // Reset the file input
            return;
        }

        let fileURL = URL.createObjectURL(file); // Generate temporary file URL

        let remark = document.querySelector(".remark-" + rowId);
        remark.textContent = "File successfully uploaded";
        remark.classList.remove("text-danger", "text-secondary");
        remark.classList.add("text-success");

        let attachment = document.querySelector(".attachment-" + rowId);
        attachment.innerHTML = `<a href="${fileURL}" target="_blank" class="text-primary">View</a>`;

        // Mark the input as valid
        input.setAttribute("data-valid", "true");
    }
}
//Upload files while also cheking - end

//Applies required  status - start
function removeFile(rowId) {
    let remark = document.querySelector(".remark-" + rowId);
    let attachment = document.querySelector(".attachment-" + rowId);
    let input = document.querySelector("#file-" + rowId);

    // If it's a required document, reset its validation status
    if (rowId === 1) {
        remark.textContent = "This document is absolutely necessary";
        remark.classList.remove("text-success");
        remark.classList.add("text-danger");

        // Mark as invalid for validation
        input.removeAttribute("data-valid");
    } else {
        remark.textContent = "Waiting for upload";
        remark.classList.remove("text-success");
        remark.classList.add("text-secondary");

        // Remove validation attribute for optional documents
        input.removeAttribute("data-valid");
    }

    // Reset attachment text
    attachment.textContent = "No file";

    // Clear the file input
    input.value = "";
}
//Applies required  status - end


//Prevents Form submission if required file is missing - start
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("uploadForm").addEventListener("submit", function (event) {
        let allValid = true;
        let requiredValid = false; // Tracks if Form 138 (rowId === 1) is uploaded
        let uploadedFileCount = 0; // Counts how many documents have been uploaded
        let toastMessage = ""; // Custom toast message

        document.querySelectorAll("input[type='file']").forEach((input) => {
            let rowId = input.id.split("-")[1]; // Extract row number
            let remark = document.querySelector(".remark-" + rowId);

            if (input.hasAttribute("data-valid")) {
                uploadedFileCount++; // Increments for every uploaded file
            }

            if (rowId === "1" && input.hasAttribute("data-valid")) {
                requiredValid = true; // Form 138 uploaded
            }

            if (rowId === "1" && !input.hasAttribute("data-valid")) {
                allValid = false;
                remark.textContent = "This document is absolutely necessary";
                remark.classList.add("text-danger");
            }
        });

        if (!allValid) {
            event.preventDefault();

            if (uploadedFileCount === 0) {
                toastMessage = "Please upload all required documents before submitting";
            } else if (uploadedFileCount >= 2 && !requiredValid) {
                toastMessage = "Please upload the absolutely necessary document";
            } else if (!requiredValid) {
                toastMessage = "At a minimum, please upload the required document";
            }

            showToast(toastMessage, "error");
        }
    });
});
//Prevents Form submission if required file is missing - end

// Toast Notification Function 1 - end
document.getElementById("fileInput").addEventListener("change", function () {
    const allowedExtensions = ["image/png", "image/jpeg", "application/pdf"];
    const file = this.files[0];

    if (file) {
        // Check if the file type is allowed
        if (!allowedExtensions.includes(file.type)) {
            showToast("Invalid file type. Please upload PNG, JPG, or PDF files.", "error");
            this.value = ""; // Reset input
            return;
        }

        // Check if the file exceeds 1MB
        if (file.size > 1 * 1024 * 1024) { // 1MB = 1 * 1024 * 1024 bytes
            showToast("File size exceeds 1MB. Please upload a smaller file.", "error");
            this.value = ""; // Reset input
            return;
        }
    }
});
// Toast Notification Function 1 - end

// Toast Notification Function 2 - start
function showToast(message, type = "error") {
    let toast = document.createElement("div");
    toast.classList.add("toast", "show");
    toast.classList.add(type === "error" ? "toast-error" : "toast-success");
    toast.innerHTML = message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => toast.remove(), 500); // Ensures smooth fade-out before removal
    }, 5000); // Display for 5s
}
// Toast Notification Function 2 - end

