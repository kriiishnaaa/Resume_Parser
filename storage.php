<?php
if(isset($_POST['submit'])){
$servername = "localhost";
$password = "";
$username = "root";
$conn = mysqli_connect($servername,$username,$password,'candresume_details');
$CandName = mysqli_real_escape_string($conn,$_POST['name']);
$CandContact = mysqli_real_escape_string($conn,$_POST['contact']);
$CandEmail = mysqli_real_escape_string($conn,$_POST['email']);
$CandAddress = mysqli_real_escape_string($conn,$_POST['address']);
$CandEducation = mysqli_real_escape_string($conn,$_POST['Education']);
$CandExperience = mysqli_real_escape_string($conn,$_POST['Experience']);
$CandTechSkills = mysqli_real_escape_string($conn,$_POST['technical_skills']);
$CandProfSkills = mysqli_real_escape_string($conn,$_POST['professional_skills']);
$conn = mysqli_connect($servername,$username,$password,'candresume_details');
if(!$conn)
{
    die("server failed to connect "+ mysqli_connect_error());
}
else{
    echo "Connection was successfull.";
}
$sql= "INSERT INTO details(CandName,CandContact,CandEmail,CandAddress,CandEducation,CandTechSkills,CandProfSkills,CandExperience) values ('$CandName','$CandContact','$CandEmail','$CandAddress','$CandEducation','$CandTechSkills','$CandProfSkills','$CandExperience')";
mysqli_query($conn,$sql);
}
?>
