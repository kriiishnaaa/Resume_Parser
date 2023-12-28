<?php
$urlEncodedData = $_GET['data'];
echo "URL-encoded Data: $urlEncodedData<br>";

$jsonString = urldecode($urlEncodedData);
$data = json_decode($jsonString, true);

echo "Decoded Data: ";
print_r($data['CandName']);

?>