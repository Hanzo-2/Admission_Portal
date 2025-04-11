(function() {
    let script = document.createElement('script');
    script.src = "https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js";
    script.onload = function() {
        let html2canvasScript = document.createElement('script');
        html2canvasScript.src = "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js";
        html2canvasScript.onload = function() {
            console.log("jsPDF and html2canvas loaded successfully!");
            enablePDFDownload();
        };
        document.body.appendChild(html2canvasScript);
    };
    document.body.appendChild(script);
})();

function enablePDFDownload() {
    document.getElementById('download-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4'); // A4 size in portrait mode
        const tables = [document.getElementById('review-table'), document.getElementById('review-table2')]; // Select both tables
        let yOffset = 1; // Initial Y position for the first table

        function addTableToPDF(table, callback) {
            html2canvas(table, { scale: 2 }).then(canvas => {
                const imgData = canvas.toDataURL('image/jpeg', 0.8);
                const imgWidth = 210;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                if (yOffset + imgHeight > 297) {
                    pdf.addPage();
                    yOffset = 1; // Reset yOffset on new page
                }

                pdf.addImage(imgData, 'JPEG', 0, yOffset, imgWidth, imgHeight);
                yOffset += imgHeight + 1; // Move down for the next table

                callback(); // Proceed to next table
            });
        }

        function processTables(index) {
            if (index < tables.length) {
                addTableToPDF(tables[index], () => processTables(index + 1));
            } else {
                pdf.save('Admission_Review.pdf');
            }
        }

        processTables(0);
    });
}

document.getElementById('edit-btn').addEventListener('click', function () {
const cells = document.querySelectorAll("#review-table td.td-2, #review-table td.td-4, #review-table2 td.td-2, #review-table2 td.td-4");

cells.forEach(cell => {
    cell.contentEditable = "true"; // Make the cell editable
    cell.classList.add("editing"); // Add the 'editing' class for styling
    cell.style.backgroundColor = "lightgreen"; // Highlight editable cells
});

document.getElementById('edit-btn').style.display = "none";
document.getElementById('save-btn').style.display = "inline-block";
});

document.getElementById('save-btn').addEventListener('click', function () {
    const cells = document.querySelectorAll("#review-table td.td-2, #review-table td.td-4, #review-table2 td.td-2, #review-table2 td.td-4");
    
    cells.forEach(cell => {
        cell.contentEditable = "false"; // Disable editing
        cell.classList.remove("editing");
        cell.style.backgroundColor = ""; // Remove the highlight
    });

    document.getElementById('edit-btn').style.display = "inline-block";
    document.getElementById('save-btn').style.display = "none";
});