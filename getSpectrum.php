<?php

$servername = "localhost";
$username = "root";
$password = "";

include('PHP_GnuPlot.php'); 
include('Database.php');

$data = json_decode(file_get_contents('php://input'), true);

function plotImage($file_name,$plot){
    $p = new GNUPlot(); 
    $p->draw2DLine( 0,0,0,0); 
    $gnudata = PGData::createFromFile($file_name, $plot); 
    $p->plotData( $gnudata, $plot, '1:2' ); 
    $p->set("autoscale"); 
    $p->setTitle($plot);
    $p->export($file_name."-".$plot); 
    // $p->close(); 
}


$result['pngFile'] = $data['name']."-".$data['plotType'];
$result['status'] = 0;

$databaseInstance = new Database($username,$password,$servername);
if($databaseInstance->DB_Connect("pw")){
    if($data['name'] != null){
        $result['file_Id'] = $databaseInstance->getFile($data['name']); //Check if file exists in DB
    
        if($result['file_Id'] != null){
            $result['image_name'] = $databaseInstance->getImage($result['file_Id'],$data['plotType']); //Check is image exists in DB
        
            if($result['image_name'] == null ){
            
                plotImage($data['name'], $data['plotType']);
                $result['status'] = $databaseInstance->updateImage($result['file_Id'], $data['plotType'], $result['pngFile']);  
                $result['image_name'] = $result['pngFile'];
            }
        
        }else{    
            plotImage($data['name'], $data['plotType']);
            $result['file_Id'] = $databaseInstance->insertFile($data['name']);// insert file in DB
            $result['image_Id'] = $databaseInstance->insertImage($result['file_Id'],$data['plotType'],$result['pngFile']);//insert image in DB
            $result['image_name'] = $result['pngFile'];
        }
    }

}
$result['delete'] = $data['plotType'];
echo json_encode($result);




?>