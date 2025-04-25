document.addEventListener("DOMContentLoaded", () => {
  //Restore previously uploaded files
  const restoreUploadedFiles = async () => {
    const response = await fetch("../components/php/script_required_docs.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "action=fetch_uploaded_docs"
    });

    const data = await response.json();

    if (data.success && data.docs) {
      Object.entries(data.docs).forEach(([key, file]) => {
        const index = key.replace("file_", "");
        document.querySelector(`.attachment-${index}`).innerHTML = `<a href="${file.path}" target="_blank" class="text-primary">View</a>`;
        document.querySelector(`#remove-button-${index}`).style.display = "inline";
        document.querySelector(`.remark-${index}`).textContent = "Upload Successful!";
        document.querySelector(`.remark-${index}`).classList.remove("text-secondary", "text-danger");
        document.querySelector(`.remark-${index}`).classList.add("text-success");
      });
    }
  };

  restoreUploadedFiles();

  // Upload File Function
  const uploadFile = async (input, index) => {
    const file = input.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append(`file_${index}`, file);
    formData.append("action", "upload");

    const response = await fetch("../components/php/script_required_docs.php", {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (data.success) {
      document.querySelector(`.attachment-${index}`).innerHTML = `<a href="${data.path}" target="_blank" class="text-primary">View</a>`;
      document.querySelector(`#remove-button-${index}`).style.display = "inline";
      document.querySelector(`.remark-${index}`).textContent = "Upload Successful!";
      document.querySelector(`.remark-${index}`).classList.remove("text-secondary", "text-danger");
      document.querySelector(`.remark-${index}`).classList.add("text-success");
    } else {
      showToast(data.error || "Upload failed.");
    }
  };

  // Remove File Function
  const removeFile = async (index) => {
    const formData = new FormData();
    formData.append("action", "remove");
    formData.append("file_index", index);

    const response = await fetch("../components/php/script_required_docs.php", {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (data.success) {
      document.querySelector(`.attachment-${index}`).textContent = "No File";
      document.querySelector(`#remove-button-${index}`).style.display = "none";

      const remarkCell = document.querySelector(`.remark-${index}`);
      remarkCell.textContent =
        index === 1
          ? "This is required to complete your application"
          : "Waiting for upload";
      remarkCell.classList.remove("text-success");
      remarkCell.classList.add(index === 1 ? "text-danger" : "text-secondary");

      document.getElementById(`file-${index}`).value = "";

      showToast("File removed successfully.");
    } else {
      showToast(data.error || "Failed to remove file.");
    }
  };

  // Make functions accessible from HTML
  window.uploadFile = uploadFile;
  window.removeFile = removeFile;

  // Validate and submit
  document.getElementById("uploadForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const response = await fetch("../components/php/script_required_docs.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "action=validate",
    });

    const data = await response.json();

    if (data.success) {
      window.location.href = "review_info.php";
    } else {
      showToast(data.error || "Please upload all required documents.");
    }
  });
});

function showToast(message, type = "error") {
  let toast = document.createElement("div");
  toast.classList.add("toast", "show");
  toast.classList.add(type === "error" ? "toast-error" : "toast-success");
  toast.innerHTML = message;

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => toast.remove(), 500);
  }, 5000);
}
