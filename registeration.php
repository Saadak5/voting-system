<?php
include '/u/b/e2203120/public_html/vote/config/db_config.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, password, register_date) VALUES (?, ?, CURRENT_TIMESTAMP)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error registering user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Team Voting</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: white;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: rgb(150, 0, 150);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container a {
            color: rgb(231, 158, 255);
        }
        .container a:hover{
            color: rgb(244, 211, 255);
        }
            h2 {
                text-align: center;
            }
            form {
                margin-top: 20px;
            }
            label {
                display: block;
                margin-bottom: 8px;
            }
            input[type="text"],
            input[type="password"],
            input[type="submit"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            input[type="submit"] {
                background-color: rgb(236, 45, 236);;
                color: #fff;
                cursor: pointer;
            }
            input[type="submit"]:hover {
                background-color: rgb(235, 102, 235);;
            }
            .return-button {
                position: fixed;
                bottom: 10px;
                left: 10px;
                font-size: 24px;
                cursor: pointer;
                text-decoration: none;
            }

            .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        <form action="registeration.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
        <?php
        if ($error_message != "") {
            echo "<div class='error-message'>$error_message</div>";
        }
        ?>
    </div>
    <a href="index.html" class="return-button">&#9664; Main menu</a>
</body>
</html>
