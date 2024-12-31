<?php 
class ConnectException extends Exception {
    
    public function __construct($message)
    {
        parent::__construct($message);
    }

};

class Connect { 
    private $connect ;
    public function __construct($servername,$username,$password){
        try{
            $this->connect =new PDO("mysql:host=$servername;dbname=gestion_salle_sport", $username, $password);
            if(!$this->connect){
                throw new ConnectException('error en connection');
            }
        }catch(ConnectException $e){
                $e->getMessage();
        }
    } 
    public function  __destruct(){}
    
    public function getConnect(){
        return $this->connect;
    }

}



?>