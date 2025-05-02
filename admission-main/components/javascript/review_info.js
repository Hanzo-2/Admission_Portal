function generatePDFAndUpload(callback) {
    const jsPDFLib = window.jspdf || window.jspdf?.default;
    const pdf = new jsPDFLib.jsPDF('p', 'mm', 'a4');
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

    function processTables(index) {
        if (index < tables.length) {
            html2canvas(tables[index], {
                scale: 2,
                windowWidth: 1920,
                windowHeight: 1080
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/jpeg', 0.8);
                const imgWidth = 210;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                if (yOffset + imgHeight > 297) {
                    pdf.addPage();
                    yOffset = 10;
                }

                pdf.addImage(imgData, 'JPEG', 0, yOffset, imgWidth, imgHeight);
                yOffset += imgHeight + 1;
                processTables(index + 1);
            });
        } else {
            // Convert to blob and upload via fetch
            const blob = pdf.output('blob');
            const formData = new FormData();
            formData.append('pdf_file', blob, 'Admission_Review.pdf');

            fetch('../components/php/upload_review_pdf.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(result => {
                console.log('PDF uploaded:', result);
                if (callback) callback();
            }).catch(err => console.error('Upload error:', err));
        }
    }
}

document.getElementById('final-submit-button').addEventListener('click', function (e) {
    // Don't let the form submit right away
    e.preventDefault();

    // Generate the PDF and upload, then submit form on success
    generatePDFAndUpload(() => {
        const form = document.querySelector('form');
        if (form) {
            form.submit();
        } else {
            console.error('Form element not found!');
        }
    });
});
