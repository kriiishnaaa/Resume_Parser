<?php
// Execute the Python script
$pythonScript = 'Text_extraction.py';
$output = shell_exec("python $pythonScript");

$jsonFile = 'data.json';
$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData, true);

$CandID = $_GET['CandID'];
$CandName = $data['CandName'];
$CandContact = $data['CandContact'];
$CandEmail = $data['CandEmail'];
$CandAddress = $data['CandAddress'];
$CandEducation = $data['CandEducation'];
$CandExperience = $data['CandExperience'];
$CandSkills = $data['CandSkills'];

header("Location: details.php?CandID=$CandID&CandName=$CandName&CandContact=$CandContact&CandEmail=$CandEmail&CandAddress=$CandAddress&CandEducation=$CandEducation&CandExperience=$CandExperience&CandSkills=$CandSkills");
exit();

?>
