<?php
include("Database.php");
$servername = "localhost";
$username = "root";
$password = "";

$databaseInstance = new Database($username, $password, $servername);
$databaseInstance->DB_Connect("pw");
//$databaseInstance->createTable("dataFiles");
//$databaseInstance->insertDataInTable("path", "ioneeeee", "dataFiles");
//$databaseInstance->insertDateInTable(1,2)

//$databaseInstance->insertData("dataImages");
//$databaseInstance->updateTable(1, "dataImages", "points","ceveaaa22222aaa");
//$databaseInstance->getImagePath(1,"dots", "dataImages");
//$temp = $databaseInstance->getFile("gigigi");
echo $temp;
?>