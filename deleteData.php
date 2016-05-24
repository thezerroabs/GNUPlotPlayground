<?php
$requestData = json_decode(file_get_contents('php://input'),true);

$responseData = $requestData;
$responseData['status'] = "nothing to delete"; 
echo json_encode($responseData);

?>
