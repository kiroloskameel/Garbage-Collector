document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission by default

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Send login data to server using AJAX
    fetch('loginCOL_process.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Successful login, store collector data in session
            sessionStorage.setItem('collectorData', JSON.stringify(data.collector));
            // Redirect user to the next page (e.g., collector profile page)
            window.location.href = "http://localhost:8080/garbage%20mangement%20project/collector%20pages/1-collector%20dashboard/%d9%8a%d8%a7%d8%b1%d8%a8COL%20.php";
        } else {
            // Login failed, display error message
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
