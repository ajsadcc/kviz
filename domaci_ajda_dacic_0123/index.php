<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Funkcija koja provjerava ime prije slanja forme
        function validateUsername() {
            let username = document.getElementById("username").value;
            let errorMessage = document.getElementById("error-message");
            let startButton = document.getElementById("start-button");

            if (username.length < 2 || username.length > 16) {
                errorMessage.innerHTML = "ime mora imati izmedju 2-16 karaktera";
                errorMessage.style.color = "red";
                startButton.disabled = true;
                return false;
            }

            errorMessage.innerHTML = "";
            startButton.disabled = false;
            return true;
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Test your knowledge!</h1>

    <!-- forma za unosenje imena -->
    <form id="start-form" method="post" action="quiz.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" onkeyup="validateUsername()">
        <button type="submit" id="start-button" name="start" disabled>Start</button>
    </form>

    <!-- poruka greke -->
    <p id="error-message"></p>
</div>
</body>
</html>
