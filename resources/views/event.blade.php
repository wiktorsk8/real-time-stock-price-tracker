<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Real-time SSE Data</title>
</head>
<body>

<h2>Real-time SSE Data</h2>
<pre id="stock-data" style="font-size: 18px; font-weight: bold;"></pre>
<pre id="active-users" style="font-size: 18px; font-weight: bold;"></pre>


<script>
    function randomString(length = 16) {
        const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        return Array.from({ length }, () => chars[Math.floor(Math.random() * chars.length)]).join("");
    }

    let isActive = true;
    const userId = randomString();

    const eventSource = new EventSource("{{ url('/stockData')}}");
    eventSource.onmessage = function (event) {
        try {
            const data = JSON.parse(event.data);
            console.log(data)
            document.getElementById("stock-data").innerText = `Price: ${data.p} USD`;
        } catch (error) {
            console.error("Invalid JSON received:", event.data);
        }
    };

    const activeUsers = new EventSource("{{ url('/activeUsers') }}");
    activeUsers.onmessage = function (event) {
        try {
            const data = event.data;
            console.log(data)
            document.getElementById("active-users").innerText = `Active users: ${data} `;
        } catch (error) {
            console.error("Invalid JSON received:", event.data);
        }
    };

    activeUsers.onerror = function () {
        console.log("Error in active users Stream. Retrying...");
        eventSource.close();
    };

    eventSource.onerror = function () {
        console.log("Error in Event Stream. Retrying...");
        eventSource.close();
    };

    setInterval(() => {
        if (isActive) {
            console.log("User is still active");
            fetch("/user/ping", {
                method: "POST",
                headers: {
                    "user-id": userId,
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                credentials: "include", // Ensures cookies are sent with the request });
            })
        }
    },  1000);

    window.addEventListener("focus", () => isActive = true);
    window.addEventListener("blur", () => isActive = false);

</script>

</body>
</html>
