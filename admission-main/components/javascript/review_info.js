(function () {
    let script = document.createElement('script');
    script.src = "https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js";
    script.onload = function () {
        let html2canvasScript = document.createElement('script');
        html2canvasScript.src = "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js";
        html2canvasScript.onload = function () {
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
        const pdf = new jsPDF('p', 'mm', 'a4');
        const tables = [document.getElementById('review-table')];
        let yOffset = 22;

        const headerText = 'Southern Philippines Institute of Science and Technology';
        const subText1 = 'Tia Maria Bldg. E. Aguinaldo Highway, Anabu 2A, Imus City, Cavite, 4103';
        const subText2 = '(046) 471-2930';
        const iconUrl = '../assets/images/spistlogo-min.png';

        const iconWidth = 17;
        const iconHeight = 17;
        const iconX = 3;
        const iconY = 2;

        function loadIconAndCreatePDF() {
            const img = new Image();
            img.src = iconUrl;
            img.onload = () => {
                pdf.addImage(img, 'PNG', iconX, iconY, iconWidth, iconHeight);

                const textX = iconX + iconWidth + 5;
                pdf.setFont("helvetica", "bold");
                pdf.setFontSize(16);
                pdf.text(headerText, textX, iconY + 6);

                pdf.setFont("helvetica", "normal");
                pdf.setFontSize(9);
                pdf.text(subText1, textX, iconY + 11);
                pdf.text(subText2, textX, iconY + 15);

                processTables(0);
            };
        }

        function addTableToPDF(table, callback) {
            html2canvas(table, { scale: 1.5 }).then(canvas => {
                const imgData = canvas.toDataURL('image/jpeg', 0.8);
                const imgWidth = 210;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                if (yOffset + imgHeight > 297) {
                    pdf.addPage();
                    yOffset = 10;
                }

                pdf.addImage(imgData, 'JPEG', 0, yOffset, imgWidth, imgHeight);
                yOffset += imgHeight + 1;
                callback();
            });
        }

        function processTables(index) {
            if (index < tables.length) {
                addTableToPDF(tables[index], () => processTables(index + 1));
            } else {
                pdf.save('Admission_Review.pdf');
            }
        }

        loadIconAndCreatePDF();
    });
}

// Edit/Save functionality
document.getElementById('edit-btn').addEventListener('click', function () {
    const cells = document.querySelectorAll("#review-table td.td-2, #review-table td.td-4");

    cells.forEach(cell => {
        cell.contentEditable = "true";
        cell.classList.add("editing");
        cell.style.backgroundColor = "lightgreen";
    });

    document.getElementById('edit-btn').style.display = "none";
    document.getElementById('save-btn').style.display = "inline-block";
});

document.getElementById('save-btn').addEventListener('click', function () {
    const cells = document.querySelectorAll("#review-table td.td-2, #review-table td.td-4");

    cells.forEach(cell => {
        cell.contentEditable = "false";
        cell.classList.remove("editing");
        cell.style.backgroundColor = "";
    });

    document.getElementById('edit-btn').style.display = "inline-block";
    document.getElementById('save-btn').style.display = "none";
});
