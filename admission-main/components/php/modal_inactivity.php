<div id="inactivityModal" class="modal-overlay">
    <div class="modal-content">
        <p>You've been inactive for a while.<br>Do you want to stay logged in?</p>
        <div class="modal-buttons">
            <button id="stayLoggedInBtn">Yes, Keep Me Logged In</button>
            <button id="logoutNowBtn">No, Log Me Out</button>
        </div>
    </div>
</div>

<style>
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
    max-width: 500px;
    width: 90%;
    box-shadow: 0 0 10px rgba(0,0,0,0.25);
    font-family: Arial, sans-serif;
}

.modal-content p {
    font-size: 25px;
    font-weight: bolder;
}

.modal-buttons {
    margin-top: 40px;
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
}

#stayLoggedInBtn {
    background-color: #4CAF50;
    border: 2px solid darkgreen;
    color: white;
}

#stayLoggedInBtn::before {
    left: auto;
    right: 0;
}

#stayLoggedInBtn:hover {
    color: #30db3f;
}

#logoutNowBtn {
    background-color: #f44336;
    border: 2px solid darkred;
    color: white;
}

#logoutNowBtn:hover {
    color: #FF073A;
}
</style>