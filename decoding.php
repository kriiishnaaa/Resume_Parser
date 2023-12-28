<?php
$jsonfile = 'data.json';
$jsondata = file_get_contents($jsonfile);
$data = json_decode($jsondata, true);
$CandEducationj = $data['CandEducation'];
$CandEducation = json_encode($CandEducationj);
echo $CandEducation;
?>
