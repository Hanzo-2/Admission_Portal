<!DOCTYPE html>
<html lang="en">

<head>
  <title>SPIST Admission - Documents</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/required_docs.css">
  <link rel="stylesheet" href="../assets/styles/form_button.css">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <script src="../components/javascript/profile_dropdown.js"></script>
</head>

<?php 
session_start();
include '../components/php/header.php';
?>

<body>
  <div class="main-content">
    <section>
      <div class="form-container">
        <div class="form-header">
          <img src="../assets/images/document_logo.png" alt="Document Logo" class="header-logo-5">
            <div class="form-header-text">
              <h2>Required Documents</h2>
              <p>Please upload the required documents.</p>
              <p>Only JPEG (.jpg), PNG (.png), and PDF (.pdf) formats are accepted, with a maximum file size of 1 mb per upload.</p>
            </div>
        </div>
    
        <form id="uploadForm" action="required_docs.php" method="post" enctype="multipart/form-data">
          <?php $baseURL = "//" . $_SERVER['HTTP_HOST']; // http or https will be auto handled ?>
            <div class="container">
              <table class="custom-table">
                <thead>
                  <tr class="tr-head">
                    <th class="th-hash">#</th>
                    <th class="th-document">Document Name</th>
                    <th class="th-attachment">Attachment</th>
                    <th class="th-upload">Upload</th>
                    <th class="th-remarks">Remarks</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $docLabels = [
                      1 => "FORM 138*",
                      2 => "PSA Birth Certificate (PhotoCopy)",
                      3 => "2pcs. 2x2 recent colored photo, white background with nameplate",
                      4 => "Certificate of Good Moral",
                      5 => "2 PCS. DOCUMENTARY STAMPS"
                  ];

                  for ($i = 1; $i <= 5; $i++):
                      $sessionKey = 'file_' . $i;
                      $docUploaded = isset($_SESSION['uploaded_docs'][$sessionKey]);
                      $doc = $docUploaded ? $_SESSION['uploaded_docs'][$sessionKey] : null;
                  ?>

                  <tr>
                    <td data-label="#"> <?= $i ?>. </td>

                    <td data-label="Document Name" class="td-document-name">
                      <?php if ($i === 1): ?>
                        <strong class="text-danger"><?= $docLabels[$i] ?></strong>
                      <?php else: ?>
                        <?= $docLabels[$i] ?>
                      <?php endif; ?>
                    </td>

                    <td data-label="Attachment" class="attachment attachment-<?= $i ?>">
                      <?php if ($docUploaded): ?>
                        <a href="<?= $baseURL . '/' . ltrim(str_replace('../', '', $doc['path']), '/') ?>" target="_blank" class="text-primary">View</a><br>
                      <?php else: ?>
                        No File
                      <?php endif; ?>
                    </td>

                    <td data-label="Upload">
                      <div class="upload-wrapper">
                        <input type="file" id="file-<?= $i ?>" name="file_<?= $i ?>" accept=".png, .jpg, .jpeg, .pdf" onchange="uploadFile(this, <?= $i ?>)">
                        <label for="file-<?= $i ?>" class="upload-btn">📁 Choose File</label>
                        <span class="remove-btn" id="remove-button-<?= $i ?>" style="<?= $docUploaded ? 'display: inline;' : 'display: none;' ?>" onclick="removeFile(<?= $i ?>)">Remove</span>
                      </div>
                    </td>

                    <?php
                      $statusClass = 'text-secondary';
                      $remarkText = 'Waiting for upload';

                      if ($docUploaded && isset($doc['status']) && $doc['status'] === 'success') {
                          $statusClass = 'text-success';
                          $remarkText = 'Upload Successful!';
                      } elseif (!$docUploaded && $i === 1) {
                          $statusClass = 'text-danger';
                          $remarkText = 'This is required to complete your application';
                      }
                    ?>

                    <td data-label="Remarks" class="remark-<?= $i ?> <?= $statusClass ?>">
                      <?= $remarkText ?>
                    </td>
                  </tr>

                <?php endfor; ?>

                </tbody>
              </table>
            </div>

          <div class="button-container">
            <a href="family_info.php"> 
                <button id="back-btn" type="button">Back</button> 
            </a>
                <button type="submit">Next</button>
          </div>
     </form>
    </div>
  </section>
</div>  
<div id="toast-container"></div>
<script src="../components/javascript/required_docs.js"></script>
<script src="../components/javascript/check_session_interval.js"></script>
<?php include '../components/php/modal_inactivity.php'; ?>
</body>
<?php include '../components/php/footer.php'; ?>
</html>
<?php
