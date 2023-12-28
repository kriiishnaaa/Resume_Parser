<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve file information
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileSize = $file['size'];
    $fileTmpName = $file['tmp_name'];

    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    // Generate a unique ID
    $uniqueId = uniqid('resume', true);

    // Construct the new file name
    $newFileName = $uniqueId . '.' . $extension;

    // Set the target directory to store the uploaded file
    $targetDirectory = 'uploads/';

    // Set the target path for the uploaded file
    $targetPath = $targetDirectory . $newFileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($fileTmpName, $targetPath)) {
        // File uploaded successfully, now insert the unique ID into the database

        // // Connect to the database
        // $host = 'localhost';
        // $username = 'root';
        // $password = '';
        // $dbname = 'candresume_details';
        // $connection = mysqli_connect($host, $username, $password, $dbname);

        // // Check if the connection was successful
        // if (!$connection) {
        //     die("Database connection failed: " . mysqli_connect_error());
        // }

        // // Insert the unique ID into the database
        // $sql = "INSERT INTO details (CandID) VALUES ('$uniqueId')";
        // if (mysqli_query($connection, $sql)) {
        //     echo 'File uploaded and unique ID inserted into the database successfully.';
        // } else {
        //     echo 'Error inserting unique ID into the database: ' . mysqli_error($connection);
        // }

        // // Close the database connection
        // mysqli_close($connection);

        // Redirect to results.html
        header('Location: execute_python.php?CandID=' . $uniqueId);
        exit();
    } else {
        echo 'Error uploading the file.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="refresh">
    <link rel="stylesheet" href="CSS files/uploadstyle.css">
    <title>upload resume</title>
</head>
<body>
  <h1 align="center">Welcome to the Resume Parser. <br>Please submit your resume here:</h1>
  <form method="POST" enctype="multipart/form-data" id="submitresume">
<div align="center" class="submit">
    <label for="resume">Submit your Resume: <br></label>
    <input type="file" name="file" id="resume" required>
</div><br>
<a href="execute_python.php" id="s"><input type="submit"></a>
</div>
  </form>  
</body>
</html>