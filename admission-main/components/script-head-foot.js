function loadHTML(id, file) {
    fetch(file)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
            return response.text();
        })
        .then(data => document.getElementById(id).innerHTML = data)
        .catch(error => console.error(`Error loading ${file}:`, error));
}




document.addEventListener("DOMContentLoaded", function () {
    loadHTML("header", "../components/header.html");            
    loadHTML("footer", "../components/footer.html"); 
});
