<?php
$servername = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password, "candresume_details");
$CandID = $_GET['CandID'];
$CandName = $_GET['CandName'];
$CandContact = $_GET['CandContact'];
$CandEmail = $_GET['CandEmail'];
$CandAddress = $_GET['CandAddress'];
$CandEducation = $_GET['CandEducation'];
$CandExperience = $_GET['CandExperience'];
$CandSkills = $_GET['CandSkills'];
if(isset($_POST['Edit'])){
header("Location: edit.php?CandID=$CandID&CandName=$CandName&CandContact=$CandContact&CandEmail=$CandEmail&CandAddress=$CandAddress&CandEducation=$CandEducation&CandExperience=$CandExperience&CandSkills=$CandSkills");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final</title>
</head>
<body style="background-color: rgb(134,134,145);">
  <div>
    <h2 align="center">Your Details.</h2><br>
    </div> 
    <div> 
    <h3>Name: <?php echo $CandName?></h3><br>
    <h3>Email: <?php echo $CandEmail?></h3><br>
    <h3>Contact: <?php echo $CandContact?></h3><br>
    <h3>Education: <?php echo $CandEducation?></h3><br>
    <h3>Skills: <?php echo $CandSkills?></h3><br>
    <h3>Experience: <?php echo $CandExperience?></h3><br>
    </div>
    <button name="Edit">Edit</button>
    <button name="Submit"><a href="thankyou.html">Submit</a></button>
</body>
</html>