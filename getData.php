<?php 
include('Database.php');

$servername = "localhost";
$username = "root";
$password = "";

   $requestData['name'] = $_GET['name'];
   $requestData['plotType'] = $_GET['plotType'];

   $databaseInstance = new Database($username, $password, $servername);
   if($databaseInstance->DB_Connect("pw")){
       
   $response['fileID'] = $databaseInstance->getFile($requestData['name']);   
   $response['imagePath'] = $databaseInstance->getImage($response['fileID'], $requestData['plotType']);
   
   echo json_encode($response);
   }
 

?>  