<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "candresume_details";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['submit'])) {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    $sql = "SELECT * FROM login_details WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = password_hash($CandPassword, PASSWORD_DEFAULT); 
        if (password_verify($inputPassword, $hashedPassword)) {

            // Prepare the query using placeholders to prevent SQL injection
            $anotherSql = "SELECT * FROM details WHERE  CandEmail= ?";
            $anotherStmt = $anotherConn->prepare($anotherSql);
            $anotherStmt->bind_param("s", $inputUsername);
            $anotherStmt->execute();

            // Store the result
            $anotherResult = $anotherStmt->get_result();

            // Check if data exists in the other database
            if ($anotherResult->num_rows > 0) {
                $anotherRow = $anotherResult->fetch_assoc();

                // Redirect the user to another webpage with the relevant details as URL parameters
                header("Location: final.php?CandName=" . $anotherRow['CandName'] . "&CandContact=" . $anotherRow['CandContact'] . "&CandSkills=" . $anotherRow['CandSkills'] . "&CandEducation=" . $anotherRow['CandEducation'] . "&CandExperience=" . $anotherRow['CandExperience'] . "&CandEmail=" . $anotherRow['CandEmail']);
                exit();
            } else {
                echo "Error: No further details found in the other database.";
            }

            // Close the connection to another database
            $anotherStmt->close();
            $anotherConn->close();
        } else {
            // Incorrect password
            echo "Invalid credentials. Please try again.";
        }
    } else {
        // User not found
        echo "Invalid credentials. Please try again.";
    }

    // Close the connection to the main database
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="CSS files/indexstyle.css">
</head>
<body background="pexels.jpg">
    <h1>Login</h1><br>
    <div class="wrapper">
        <form action="index.php" method="post">
            <div class="credentials-user">
                <label for="username"></label>    
                <input type="text" placeholder="Email" id="username" name="username" required>
            </div>
            <br>
            <div class="credentials-password">
                <label for="password"></label>
                <input type="password" placeholder="Password" id="password" name="password" required>
            </div>
            <br>
            <div class="remeber-forgot">
                <input type="checkbox">Remember Me.
                <a href="#">forgot password</a>
            </div>
            <br>
            <div class="submit">
                <input type="submit" name="submit" value="LOGIN">
            </div>
            <br>
            <div class="link">
                <p>Don't Have an account? <a href="uploadres.php">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
