<?php
$currentUrl = $_SERVER['REQUEST_URI'];

$queryString = parse_url($currentUrl, PHP_URL_QUERY);
parse_str($queryString, $params);

// $CandID = $params['CandID'];
// $CandName = $params['CandName'];
// $CandContact = $params['CandContact'];
// $CandAddress = $params['CandAddress'];
// $CandExperience = $params['CandExperience'];
// $CandSkills = $params['CandSkills'];
// $CandEducation = $params['CandEducation'];
// $CandEmail = $params['CandEmail'];

// Use the retrieved parameters as needed
$CandID = $_GET['CandID'];
$CandName = $_GET['CandName'];
$CandContact = $_GET['CandContact'];
$CandEmail = $_GET['CandEmail'];
$CandAddress = $_GET['CandAddress'];
$CandEducation = $_GET['CandEducation'];
$CandExperience = $_GET['CandExperience'];
$CandSkills = $_GET['CandSkills'];
echo $CandSkills;

$servername = "localhost";
$password = "";
$username = "root";
$conn = mysqli_connect($servername, $username, $password, 'candresume_details');
$conn1 = mysqli_connect($servername,$username,$password,'candresume_details');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $CandName1 = mysqli_real_escape_string($conn, $_POST['name']);
    $CandContact1 = mysqli_real_escape_string($conn,$_POST['contact']);
    $CandEmail1 = mysqli_real_escape_string($conn, $_POST['email']);
    $CandAddress1 = mysqli_real_escape_string($conn, $_POST['address']);
    $CandEducation1 = mysqli_real_escape_string($conn, $_POST['Education']);
    $CandExperience1 = mysqli_real_escape_string($conn, $_POST['Experience']);
    $CandSkills1 = mysqli_real_escape_string($conn, $_POST['technical_skills']);
    $CandPassword = mysqli_real_escape_string($conn, $_POST['Password']);

    if (!$conn) {
        die("server failed to connect " + mysqli_connect_error());
    } else {
        echo "Connection was successful.";
    } 
    $sql= "INSERT INTO details(CandID, CandName,CandContact,CandEmail,CandAddress,CandEducation,CandSkills,CandExperience) values ('$CandID','$CandName1','$CandContact1','$CandEmail1','$CandAddress1','$CandEducation1','$CandSkills1','$CandExperience1')";
    if (mysqli_query($conn, $sql)) {
        echo "Data uploaded successfully";
    } else {
        echo "Error uploading data" . mysqli_error($conn);
    }
    $CandPassword1 = password_hash($CandPassword,PASSWORD_DEFAULT);
    $sql1="INSERT INTO login_details(Username, CandPassword) values ('$CandEmail1', '$CandPassword1')";
    if (mysqli_query($conn1, $sql1)){
      echo "Data uploaded successfully";
    }
    else{
      echo "error uploading error". mysqli_error($conn1);
    }
    header("Location: final.php?CandID=$CandID&CandName=$CandName&CandContact=$CandContact&CandEmail=$CandEmail&CandAddress=$CandAddress&CandEducation=$CandEducation&CandExperience=$CandExperience&CandSkills=$CandSkills");
    mysqli_close($conn1);
    mysqli_close($conn);
 } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS files/detailstyle.css">
    <title>Details</title>
    <!-- <script src="display.js"></script>  -->
</head>
<body>
    <h2 align="center">Details Extracted :</h2>
    <form action="" id="form" method="post">
        <div align="center">
            <label for="CandID"> ResumeId:</label>
            <input type="text" name="CandID" id="CandID" value="<?php echo $CandID ?>" readonly>
        </div>
        <br>
      <div id="data-container" align="center">
        <label for="CandName">Name :</label>
        <input type="text" name="name" value="<?php echo $CandName ?>" id="CandName">
      </div> 
      <br>
      <div id="data-container" align="center">
        <label for="CandContact">Contact :</label>
        <input type="text" name="contact" id="CandContact" value="<?php echo $CandContact ?>">
      </div><br>
      <div id="data-container" align="center">
        <label for="CandEmail">Email :</label>
        <input type="text" name="email" id="CandEmail" value="<?php echo $CandEmail ?>">
      </div><br>
      <div id="data-container" align="center">
        <label for="CandAddress">Address :</label>
        <input type="text" name="address" id="CandAddress" value="<?php echo $CandAddress ?>">
      </div><br>
      <div id="data-container" align="center" class="educ">
        <label for="CandEducation">Education :</label>
        <input type="text" name="Education" id="CandEducation" value="<?php echo $CandEducation ?>">
      </div><br>
      <div id="data-container" align="center">
        <label for="CandExperience">Experience :</label>
        <input type="text" name="Experience" id="CandExperience" value="<?php echo $CandExperience ?>">
      </div><br>
      <div align="center" id="data-container">
        <label for="CandTechSkills">Skills :</label>
        <input type="text" name="technical_skills" id="CandSkills" value="<?php echo $CandSkills ?>">
      </div><br>
      <div align="center">
        <label for = "CandPassword"> Set Password: </label>
        <input type="text" name="Password" id="CandPassword" placeholder="password" required>
      </div><br>
      <div align="center">
        <input type="submit" name="submit" value="upload data"></input>
      </div>
    </form>
</body>
</html>
