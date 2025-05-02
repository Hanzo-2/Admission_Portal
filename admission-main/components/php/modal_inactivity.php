<div id="inactivityModal" class="modal-overlay">
  <div class="modal-content">
    <p id="modalText">
      You've been inactive for a while.<br>
      Do you want to stay logged in?
    </p>

    <div id="initialButtons" class="modal-buttons">
      <button id="stayLoggedInBtn">Yes, Keep Me Log In</button>
      <button id="logoutNowBtn">No, Log Me Out</button>
    </div>

    <div id="confirmLogoutButtons" class="modal-buttons" style="display: none;">
      <button id="confirmNoBtn">No, Go Back</button>
      <button id="confirmYesBtn">Yes, Log Me Out</button>
    </div>

    <span class="countdown">
      Auto Log Out in <strong class="inactcountdown" id="inactcountdown"></strong> seconds...
    </span>
  </div>
</div>


<style>

.countdown {
    font-size: 18px;
}

.inactcountdown {
    color: red;
}

.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 999;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    border-top: 30px solid red;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    max-width: 600px;
    width: 90%;
    box-shadow: 0 0 10px rgba(0,0,0,0.25);
    font-family: Arial, sans-serif;
}

.modal-content p {
    font-size: 30px;
    font-weight: bolder;
}

.modal-buttons {
    margin-top: 40px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    width: 100%;
}

.modal-buttons button {
    padding: 10px;
    margin: 10px;
    border-radius: 5px;
    font-size: 15px;
    cursor: pointer;
    width: 48%;
}

#countdown {
    display: inline-block;
    min-width: 2ch; /* space for at least 2 characters */
}


/* Existing button styles for initial buttons */
#stayLoggedInBtn,
#confirmNoBtn {
    background-color: #4CAF50;
    border: 2px solid darkgreen;
    color: white;
}

#stayLoggedInBtn:hover,
#confirmNoBtn:hover {
    color: #30db3f;
}

/* Matching logout buttons */
#logoutNowBtn,
#confirmYesBtn {
    background-color: #f44336;
    border: 2px solid darkred;
    color: white;
}

#logoutNowBtn:hover,
#confirmYesBtn:hover {
    color: #FF073A;
}

#stayLoggedInBtn::before, 
#confirmNoBtn::before {
    left: auto;
    right: 0;
}
</style>