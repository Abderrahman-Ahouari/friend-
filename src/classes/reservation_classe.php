<?php 

require_once ("connect.php");

class Reservation {
    
    private $id_reservation ;
    private $id_Membre ;
    private $id_activite; 
    private $date_reservation ; 
    private  $statut;
    public function __construct($id_reservation ='',$id_Membre ='',$id_activite='',$date_reservation='',$statut='encour')
    {
        $this->id_reservation = $id_reservation ;
        $this->id_Membre =$id_Membre ;
        $this->id_activite=  $id_activite; 
        $this->date_reservation =  $date_reservation ; 
        $this->statut = $statut;
    }
    public function setID($id){
         $this->id_reservation =$id;
    }
    public function setIdMember($id){ 
        $this->id_Membre = $id;
    }
    public function setIdActivite($id){
        $this->id_activite =$id;
    }
    public function setIddate($date){
        $this->date_reservation =$date;
    }
    public function setIdStatut($statut){
        $this->statut;
    }
    public function getID(){
        return   $this->id_reservation;
    }
    public function getIdMember(){
        return $this->id_Membre;
    }
    public function getIdActivite(){
        return $this->id_activite;
    }
    public function getIdate(){
        return $this->date_reservation;
    }
    public function getIdStatut(){
        return $this->statut;
    }    
    public function insert(){
        $connect = new Connect("localhost","root","12345");
        $stmt =$connect->getConnect()->prepare("select *  from reservations where id_reservation =  :id");
        $id = $this->getID(); 
        $stmt->bindParam(":id",$id);
        $stmt->execute();
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // $this->setID($row['id_reservation']);
            $this->setIdMember($row['id_Membre']);
            $this->setIdActivite($row['id_activite']);
            $this->setIddate($row['date_reservation']);
            $this->setIdStatut($row['statut']);
        }
    }
}

?>