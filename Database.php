<?php

class Database{
	public $connection;
	private $username;
	private $password;
	private $host;


	public function __construct($username, $password, $host){
		$this->username = $username;
		$this->password = $password;
		$this->$host = $host;

	}

	public function DB_Connect($database){
		$this->connection = new mysqli($this->host, $this->username, $this->password,$database);

		// Check connection
		if ($this->connection->connect_error) {
			// die("Connection failed: " . $this->connection->connect_error);
            return false;
		}else{
            return true;
        } 
		// echo "Connected successfully";
        

	}

	function createTable($tableName){


		$sql="CREATE TABLE $tableName
				(
				Paths VARCHAR(255),
				Name VARCHAR(255),
				F_ID Int PRIMARY KEY AUTO_INCREMENT
				)";

				if($this->connection->query($sql)==true){
					echo "Table  created successfully!";
				}else{
					echo "Error creating table:";
				}

	}

	function insertDataInTable($path, $name, $table){
		$sql = "INSERT INTO $table (`Paths`, `Name`) VALUES ('$path', '$name') ";
		if($this->connection->query($sql)==true){
					echo "Insert successfully";
				}else{
					echo "Error inserting";
					echo ($this->connection->error);
				}


	} 
    
    function insertFile($file_name){
        
        $sql = "INSERT INTO datafiles(Name) VALUES (?) ";
        
        if($stmt = $this->connection->prepare($sql)){
            $stmt->bind_param("s",$file_name);
            $stmt->execute();
            return $stmt->insert_id;
            $stmt->close();
            
        }else{
            return -200;
        }
           
    }
    

    
    function insert($table,$path,$name){
        $sql = "INSERT INTO $table(Paths,Name) VALUES (?,?)";
        if($stmt = $this->connection->prepare($sql)){
            $stmt->bind_param("ss",$path,$name);
            $stmt->execute();
            $inserted_id = $stmt->insert_id;
            $stmt->close();
            if($inserted_id != 0){
                
            return true;
            }
            
        }else{
            return false;
        }
           
    }
    
    function updateImage($id,$field, $path){
        $sql = "UPDATE dataimages SET $field = ? WHERE F_id = ? "; 
           if($stmt = $this->connection->prepare($sql)){
                $stmt->bind_param('si',$path,$id);
                $stmt->execute();
                $stmt->close();
                return 200;
           }else{
               return -78;
           }
    }
    

    
    function getFile($path){
            $sql = " SELECT F_Id FROM dataFiles WHERE Name = ? " ;
        if($stmt = $this->connection->prepare($sql)){
            $stmt->bind_param('s',$path);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($result);
                        if($stmt->fetch()){
                            return $result;
                        }else{
                            return $result;
                        }
            $stmt->free_result();
            $stmt->close();
        }   
    }
    
          function getImage($file_id,$plotType){
        $sql = " SELECT $plotType FROM dataImages WHERE F_id = ? " ;
                        
        if($stmt = $this->connection->prepare($sql)){
            $stmt->bind_param("i",$file_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($result);
            if($stmt->fetch()){
                return $result;
            } else{
                return $result;
            }
            $stmt->free_result();
            $stmt->close();
        }            
    }
    
    function insertImage($file_id, $plotType,$file_path){
          $sql = "INSERT INTO dataimages (F_Id, $plotType) VALUES (?,?)";
        if($stmt = $this->connection->prepare($sql)){
            $stmt->bind_param("is",$file_id, $file_path);
            $stmt->execute();
            return $stmt->insert_id;
            $stmt->close();
    }else{
        return -200;
    }
    
    
    }
    
}

?>