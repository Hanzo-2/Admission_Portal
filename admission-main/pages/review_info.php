<!DOCTYPE html>
<html lang="en">
<head>
  <title>SPIST Admission - Review</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/review_info.css">
  <link rel="stylesheet" href="../assets/styles/form_button.css">
  <link rel="icon" href="../assets/images/spistlogo_icon.ico">
  <script src="../components/javascript/profile_dropdown.js"></script>
</head>

<?php 
session_start();
include '../components/php/header.php'; 
include '../components/php/script_review_info.php';
?>

<body>
<div class="main-content">
  <section>
    <div class="form-container">
      <div class="form-header">
        <img src="../assets/images/document_logo.png" alt="Document Logo" width="70px" height="75px">
         <div class="form-header-text">
          <h2>Review Information</h2>
         </div>
      </div>

      <form id="uploadForm" action="review_info.php" method="post">
        <div class="container">
            <table class="custom-table" id="review-table">
                <thead> <!--Admission Application - Start -->
                    <tr>
                        <th colspan="6" class="th-header">Admission Application</th>
                    </tr>
                </thead>
                <tbody>
                    <tr> 
                        <td class="td-1">School Campus:</td>
                        <td class="td-2" value=""><?= htmlspecialchars($_SESSION['school_campus'] ?? 'ANABU') ?></td>
                        <td class="td-1">Classification:</td>
                        <td class="td-2" value=""><?= htmlspecialchars($_SESSION['classification'] ?? 'College') ?></td>
                        <td class="td-1">Grade/Level:</td>
                        <td class="td-2" value=""><?= htmlspecialchars($_SESSION['grade_level'] ?? '1st Year') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">Year & Term:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['academic_year_term'] ?? '2025 - 2026 - First Semester') ?></td>
                        <td class="td-1">Application Type:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['application_type'] ?? '') ?></td>
                    </tr>
                    
                    <tr>
                        <td class="td-1">Academic Program:</td>
                        <td class="td-2" colspan="5" value=""><?= htmlspecialchars($_SESSION['preferred_course'] ?? '') ?></td>
                    </tr>
                </tbody> <!--Admission Application - End -->

                <thead> <!--Personal Information - Start -->
                    <tr>
                        <th colspan="6" class="th-header">Student Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr> 
                        <td class="td-1">Student Name:</td>
                        <td class="td-2" colspan="5" value="">
                            <?php if (!empty($_SESSION['personal_surname'])) { echo $_SESSION['personal_surname'] . ', '; } ?>
                            <?= htmlspecialchars($_SESSION['personal_firstname'] ?? '') ?>
                            <?= htmlspecialchars($_SESSION['personal_middlename'] ?? '') ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="td-1">Date of Birth:</td>
                        <td class="td-2" colspan="2"><?= isset($_SESSION['personal_birthdate']) && $_SESSION['personal_birthdate'] !== ''? htmlspecialchars((new DateTime($_SESSION['personal_birthdate']))->format('F j, Y')): '' ?></td>                        
                        <td class="td-1">Place of Birth:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['birthplace'] ?? '') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">Sex:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['sex'] ?? '') ?></td>
                        <td class="td-1">Civil Status:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['civilstatus'] ?? '') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">Nationality:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['nationality'] ?? '') ?></td>
                        <td class="td-1">Religion:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['religion'] ?? '') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">Student Address:</td>
                        <td class="td-2" colspan="5" value="">
                            <?php if (!empty($_SESSION['address'])) { echo $_SESSION['address'] . ', '; } ?>
                            <?php if (!empty($_SESSION['selected_barangay'])) { echo $_SESSION['selected_barangay'] . ', '; } ?>
                            <?php if (!empty($_SESSION['selected_city'])) { echo $_SESSION['selected_city'] . ', '; } ?>
                            <?= htmlspecialchars($_SESSION['selected_province'] ?? '') ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="td-1">Contact Number:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['personal_contact'] ?? '') ?></td>
                        <td class="td-1">Telephone Number:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['telephone'] ?? '') ?></td>
                    </tr>
                        
                    <tr>
                        <td class="td-1">Email:</td>
                        <td class="td-4" colspan="5" value=""><?= htmlspecialchars($_SESSION['personal_email'] ?? '') ?></td> 
                    </tr>
                </tbody> <!--Personal Information - End -->

                <thead> <!--Educational Background - Start -->
                    <tr>
                        <th colspan="6" class="th-header">Educational Background</th>
                    </tr>
                </thead>
                <tbody>
                    <tr> 
                        <td class="td-1">LRN:</td>
                        <td class="td-2" colspan="2" value=""><?= (isset($_SESSION['lrn_num']) && $_SESSION['lrn_num'] == 0) ? 'N/A' : htmlspecialchars($_SESSION['lrn_num'] ?? '') ?></td>
                        <td class="td-1">School Level:</td>    
                        <td class="td-2" colspan="2">Senior High School</td>    
                    </tr>

                    <tr> 
                        <td class="td-1">Student Type:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['student_type'] ?? '') ?></td>
                        <td class="td-1">School Type:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['school_type'] ?? '') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">School Name:</td>
                        <td class="td-2" colspan="5" value=""><?= htmlspecialchars($_SESSION['school_name'] ?? '') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">School Address:</td>
                        <td class="td-2" colspan="5" value=""><?= htmlspecialchars($_SESSION['school_address'] ?? '') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">Track/Strand:</td>
                        <td class="td-2" colspan="5" value=""><?= htmlspecialchars($_SESSION['track_strand'] ?? '') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">Year of Graduation:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['year_graduation'] ?? '') ?></td>
                        <td class="td-1" colspan="2">Senior High School General Average:</td>
                        <td class="td-2" value=""><?= htmlspecialchars($_SESSION['shs_average'] ?? '') ?></td>
                    </tr>
                </tbody> <!--Educational Background - End -->

                <thead> <!-- Family Information - Start -->
                    <tr>
                        <th colspan="6" class="th-header">Family Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr> 
                        <td class="td-1">Father's Name:</td>
                        <td class="td-2" colspan="5" value="">
                            <?php if (!empty($_SESSION['father_surname'])) { echo $_SESSION['father_surname'] . ', '; } ?>
                            <?= htmlspecialchars($_SESSION['father_firstname'] ?? '') ?>
                            <?= htmlspecialchars($_SESSION['father_middlename'] ?? '') ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="td-1">Date of Birth:</td>
                        <td class="td-2" colspan="2" value=""><?= isset($_SESSION['personal_birthdate']) && $_SESSION['father_birthdate'] !== ''? htmlspecialchars((new DateTime($_SESSION['father_birthdate']))->format('F j, Y')): '' ?></td>
                        <td class="td-1">Contact Number:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['father_contact'] ?? '') ?></td>
                    </tr>

                    <tr> 
                        <td class="td-1">Mother's Name:</td>
                        <td class="td-2" colspan="5" value="">
                            <?php if (!empty($_SESSION['mother_surname'])) { echo $_SESSION['mother_surname'] . ', '; } ?>
                            <?= htmlspecialchars($_SESSION['mother_firstname'] ?? '') ?>
                            <?= htmlspecialchars($_SESSION['mother_middlename'] ?? '') ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="td-1">Date of Birth:</td>
                        <td class="td-2" colspan="2" value=""><?= isset($_SESSION['personal_birthdate']) && $_SESSION['mother_birthdate'] !== ''? htmlspecialchars((new DateTime($_SESSION['mother_birthdate']))->format('F j, Y')): '' ?></td>
                        <td class="td-1">Contact Number:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['mother_contact'] ?? '') ?></td>
                    </tr>

                    <tr> 
                        <td class="td-1">Guardian's Name:</td>
                        <td class="td-2" colspan="5" value="">
                        <?php if (!empty($_SESSION['guardian_surname'])) { echo $_SESSION['guardian_surname'] . ', '; } ?>
                        <?= htmlspecialchars($_SESSION['guardian_firstname'] ?? '') ?>
                        <?= htmlspecialchars($_SESSION['guardian_middlename'] ?? '') ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="td-1">Present Address:</td>
                        <td class="td-2" colspan="5" value="">
                            <?php if (!empty($_SESSION['guardian_address'])) { echo $_SESSION['guardian_address'] . ', '; } ?>
                            <?php if (!empty($_SESSION['guardian_barangay'])) { echo $_SESSION['guardian_barangay'] . ', '; } ?>
                            <?php if (!empty($_SESSION['guardian_city'])) { echo $_SESSION['guardian_city'] . ', '; } ?>
                            <?= htmlspecialchars($_SESSION['guardian_province'] ?? '') ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="td-1">Contact Number:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['guardian_contact'] ?? '') ?></td>
                        <td class="td-1">Telephone Number:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['guardian_telephone'] ?? '') ?></td>
                    </tr>
                        
                    <tr>
                        <td class="td-1">Email:</td>
                        <td class="td-4" colspan="5" value=""><?= htmlspecialchars($_SESSION['guardian_email'] ?? '') ?></td> 
                    </tr>
                </tbody> <!--Family Information - End -->
                
                <thead>
                    <tr>
                        <th colspan="6" class="th-header">Person to Contact in Case of Emergency</th>
                    </tr>
                </thead>

                <tbody>
                    
                    <tr>
                        <td class="td-1" colspan="1">Complete Name:</td>
                        <td class="td-2" colspan="5" value=""><?= htmlspecialchars($_SESSION['emergency_complete_name'] ?? '') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">Complete Address:</td>
                        <td class="td-2" colspan="5" value=""><?= htmlspecialchars($_SESSION['emergency_complete_address'] ?? '') ?></td>
                    </tr>

                    <tr>
                        <td class="td-1">Contact Number:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['emergency_contact'] ?? '') ?></td>
                        <td class="td-1">Telephone Number:</td>
                        <td class="td-2" colspan="2" value=""><?= htmlspecialchars($_SESSION['emergency_telephone'] ?? '') ?></td>
                    </tr>
                        
                    <tr>
                        <td class="td-1">Email:</td>
                        <td class="td-4" colspan="5" value=""><?= htmlspecialchars($_SESSION['emergency_email'] ?? '') ?></td> 
                    </tr>
                </tbody>

            </table>

            <?php
            $docNames = [
                1 => 'FORM 138',
                2 => 'PSA Birth Certificate (PhotoCopy)',
                3 => '2pcs. 2x2 recent colored photo, white background with nameplate',
                4 => 'Certificate of Good Moral',
                5 => '2 PCS. DOCUMENTARY STAMPS'
            ];

            $googleId = $_SESSION['google_id'] ?? null;
            $uploadedDocs = $googleId && isset($_SESSION['uploaded_docs'][$googleId]) ? $_SESSION['uploaded_docs'][$googleId] : [];
            ?>

            <table class="custom-table" id="review-table2">
                <thead>
                    <tr>
                        <th colspan="6" class="th-header">Required Documents</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="tr-td-labels">
                        <td class="tr-td-number">#</td>
                        <td colspan="4">Requirements</td>
                        <td class="tr-td-remarks">Remarks</td>
                    </tr>

                    <?php foreach ($docNames as $index => $docLabel): ?>
                        <tr>
                            <td class="tr-td-number"><?= $index ?>.</td>
                            <td colspan="4"><?= htmlspecialchars($docLabel) ?></td>
                            <td class="tr-td-remarks">
                                <?php if (isset($uploadedDocs["file_$index"])): ?>
                                    <a href="<?= $uploadedDocs["file_$index"]['path'] ?>" target="_blank" class="btn-view">View</a>
                                <?php else: ?>
                                    No File
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="p-reminder">Please take a moment to review your details before submitting to ensure everything is correct</p>

            <table class="custom-table3">
                <tr>
                    <td class="custom-table-td3">By Clicking the box,</td>
                </tr>

                <tr>
                    <td class="custom-table-text">
                    All personal data collected by the Southern Philippines Institute of Science & Technology is stored securely and is accessible only to authorized personnel.<br><br>
                    Personal data will not be shared with third parties without the consent of student/parents, except when required by law or necessary for providing services, such as accreditation or regulatory compliance.<br><br>
                    Retention of data will be limited to the duration necessary to fulfill its purpose or as mandated by applicable laws. Once no longer required, records will be disposed of, to protect the privacy of individuals.<br><br>
                    However, the academic records will remain intact in school.<br><br>
                    By submitting personal information during admission and enrollment, students or guardians consent to the collection, processing, and storage of their data as outlined in this policy.
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="custom-table-checkbox">
                        <label class="checkbox-text">
                        <input type="checkbox" class="checkbox" name="terms_accept" required>
                        <strong>By clicking on Authorize and Accept, I agree to the Terms and Data Policy.</strong>
                        </label>
                    </td>
                </tr>
            </table>
        </div>

        <div class="button-container">
            <a href="required_docs.php"> 
                <button id="back-btn" type="button">Back</button> 
            </a>
            <button id="download-pdf" type="button">Download PDF</button>
            <button id="edit-btn" type="button">Edit</button>
            <button id="save-btn" type="button" style="display: none;">Save Changes</button>
            <button type="submit">Submit</button>
        </div>
     </form>
    </div>
  </section>
</div>
<script src="../components/javascript/format_validate.js"></script>
<script src="../components/javascript/check_session_interval.js"></script>
<script src="../components/javascript/autosave.js"></script>
<script src="../components/javascript/select_province_city_barangay.js"></script>
<script src="../components/javascript/review_info.js"></script>
<?php include '../components/php/modal_inactivity.php'; ?>
</body>
<?php include '../components/php/footer.php'; ?>
</html>