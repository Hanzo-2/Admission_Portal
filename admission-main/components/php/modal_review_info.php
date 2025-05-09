<div id="editModal" class="modal" style="display: none;">
    <div class="modal-review">
        <p><strong>Which page would you like to edit?</strong></p>
        <button type="button" onclick="location.href='admission_application.php?from=review'">#1 Admission Application</button>
        <button type="button" onclick="location.href='personal_info.php?from=review'">#2 Personal Information</button>
        <button type="button" onclick="location.href='educational_bg.php?from=review'">#3 Educational Background</button>
        <button type="button" onclick="location.href='family_info.php?from=review'">#4 Family Information</button>
        <button type="button" onclick="location.href='required_docs.php?from=review'">#5 Required Documents</button>
        <button type="button" id="go-back-btn">Go Back</button>
    </div>
</div>

<div id="loadingOverlay" style="display: none;">
  <div class="loading-content">
    <div class="spinner">
      <div class="spinner-ring"></div>
      <img src="../assets/images/spistlogo.png" alt="Portal Logo" class="loading-logo">
    </div>
    <p class="loading-message">Processing your application...<br>Please do not close or refresh this page.</p>
  </div>
</div>

<style>
#loadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(121, 121, 121, 0.85);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    flex-direction: column;
  }
  
  .loading-content {
    text-align: center;
    animation: fadeIn 0.5s ease-in-out;
  }
  
  .spinner {
    position: relative;
    width: 250px;
    height: 250px;
    margin: 0 auto 20px;
  }
  
  .spinner-ring {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 17px solid #e0e0e0;
    border-top: 17px solid green;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }
  
  .loading-logo {
    width: 90%;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); 
  }
  
  .loading-message {
    font-family: Arial, sans-serif;
    font-size: clamp(10px, 5vw, 40px);
    font-weight: bold;
    color: white;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }

</style>