<?php
// require_once ("connect.php");
require_once("reservation_classe.php");
require_once("activites_classe.php");
class Utilisateur {
    protected $id;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $role;
    protected $password;
    protected $telephone ;
   
    public function __construct($nom ='' ,$prenom ='',$email='',$role='membre',$password ='',$telephone=''){
        $this->nom =$nom;
        $this->prenom =$prenom;
        $this->email =$email;
        $this->role =$role;
        $this->password =$password;
        $this->telephone =$telephone;
    }
    public function  __destruct(){}

    public function setNom($nom){
        $nom =trim($nom);
        $condition = "/^[a-zA-Z\s]{3,40}/i";
        if(empty($nom)){
            echo "entre un mot ne pas vide ";
        }else 
        if(preg_match($condition,$nom)){
            $this->nom=$nom;
        } 
        else 
            echo " le forme de mot il entre ne pas vrue";
    }
    public function setPrenom($prenom){
        $prenom = trim($prenom);
        if(empty($prenom) || !preg_match("/^[a-zA-Z\s]{3,40}/i",$prenom))
            return  " entre votre prenom ne pas  vide et containe sof le caractire (a-z A-Z)";        
        else
            $this->prenom =$prenom;
        return "";
    }
    public function setTelephone($telephone){
        $telephone = trim($telephone);
        if(empty($telephone) || !preg_match("/^\+212[6|7|5]{1}[0-9]{8}$/",$telephone))
            return "etre le numero detelephene sur forme +2125******** ou +2126******** ou +2127********";
        else 
            $this->telephone=$telephone;
        return "";
    }
    public function setEmail($email){
        $email = trim($email);
        if(empty($email) || !preg_match("/^[a-zA-Z]{5,20}@gmail\.com$/",$email))
            return "etre le numero detelephene sur forme exmap@gamil.com";
        else 
            $this->email=$email;
        return "";
    }
    public function setId($id){
        // if($id instanceof int){
            $this->id =$id;
            // return " ";
        // }
        // else 
        //     return "entre la id sure type entre";
    }
    public function setRole($role){
        if($role != "admin" && $role != "membre")
            return "error";
        else 
            $this->role = $role;
    }
    public function setPassword($password){
        $password = trim($password);
        if(strlen($password)<8 ){
            // || !preg_match("/^[a-zA-Z\s]{5,20}[0-9]{1,5}[-_@+)(\'\"$*^:.,]{1,20}$/",$password)
            return "entre password contains ou mois un nomber etou mois un  caractire spisaile et lengoure superer 8 ";
        }
        else 
            $this->password =$password;
        return "";
    }
    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getTelephone(){
        return $this->telephone;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getId(){
        return $this->id;
    }
    public function getRole(){
        return $this->role;
    }
    public function setSession(){
        // session_start();
        $_SESSION['email']=$this->getEmail();
        $_SESSION['role'] =$this->getRole();
    }
    public function logout(){
        session_unset();
        session_destroy();
    }


    public function insert(){
        $connect = new Connect("localhost","root","12345");
            $stmt =$connect->getConnect()->prepare("select *  from utilisateurs where email =  :email");
            $email = $this->email; 
            $stmt->bindParam(":email",$email);
            $stmt->execute();
            if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $this->setId($row['id_utilisateur']);
                $this->setPrenom($row['prenom']);
                $this->setNom($row['nom']);
                $this->setEmail($row['email']);
                $this->setRole($row['role']);
                $this->setTelephone($row['telephone']);
            }
    }
    
    public function login(){
        $error ="";
        $connect = new Connect("localhost","root","12345");
        $stmt = $connect->getConnect()->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->bindParam(":email",$this->email);
        $stmt->execute();
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            if (password_verify($this->getPassword(), $row['password'])) {
                
                $this->setRole($row['role']);
                $this->setSession();
                if($row['role']=="admin"){
                    header('Location: home_admin.php');
                    $error = "page homme admin";
                    exit;
                }
                elseif($row['role']=="membre"){
                    header('Location: home_user.php');
                    $error = "page homme client";
                    exit;
                }
                else  $error = "role";
            }else 
            $error ="mode passe ne pas vrée";
        }else
        $error ="email  ne existe pas";
        return  $error;
    }

    public function signin($nom , $prenom ,$email,$role,$password,$telephone ){
        $connect = new Connect("localhost","root","12345");
        $stmt =$connect->getConnect()->prepare("select * from utilisateurs  where email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        if(!($row = $stmt->fetch(PDO::FETCH_ASSOC))){
            $this->setPrenom($prenom );
            $this->setnom($nom );
            $this->setemail($email );
            $this->setrole($role );
            $password = password_hash($password, PASSWORD_BCRYPT);
            $this->setpassword($password); 
            $this->settelephone($telephone );
            $stmt =$connect->getConnect()->prepare("insert into utilisateurs (nom,prenom,email,telephone,role,password) values (:nom,:prenom,:email,:telephone,:role,:password)");
            $stmt->bindParam(":nom", $nom);
            $stmt->bindParam(":prenom", $prenom);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":telephone", $telephone);
            $stmt->bindParam(":role", $role);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            echo "<h1> valid</h1>";
            return 1;
        }
        echo "<h1> eroo</h1>";
        return 0; 
    }
    
};
 

class Members extends Utilisateur{
    public function __construct(){
        parent:: __construct('' ,'','','membre','','');
    }
    public  function reservez($activite){
        $connect =  new Connect("localhost","root","12345");
        if($activite instanceof Activites){
            $stmt = $connect->getConnect()->prepare("insert into reservations(id_Membre,id_activite) values (:idm,:ida)");
            $id=$this->getId();
            $ida=$activite->get_id_activite();
            $stmt->bindParam(":idm",$id);
            $stmt->bindParam(":ida",$ida);
            $stmt->execute();
        }
    }
    public function editReservation($reservation,$newReservation){
        $connect = new Connect("localhost","root","12345");
        if($reservation instanceof Reservation  && $newReservation instanceof Reservation){
            $stmt = $connect->getConnect()->prepare("update reservation  set date_reservation =:date where id_reservation = :id ");
            $stmt->bindParam(":date",$newReservation->getIdate());
            $stmt->bindParam(":id",$reservation->getId());
            $stmt->execute();
        }
    }
    public function sepprimeReservation($reservation){
        $connect = new Connect("localhost","root","12345");
        if($reservation instanceof Reservation){
            $stmt = $connect->getConnect()->prepare("delete from reservations where id_reservation = :id ");
            $id=$reservation->getID();
            $stmt->bindParam(":id",$id);
            $stmt->execute();
    }
    }
    public function listeRservation(){
        $connect = new Connect("localhost","root","12345");
            $stmt = $connect->getConnect()->prepare("select r.* ,a.nom   from  reservations r , activites a  where  r.id_activite =a.id_activite and  r.id_Membre = :id");
            $id =$this->getId();
            $stmt->bindParam(":id",$id);
            $stmt->execute();
        return $stmt;
    }
    public function listActivite(){
        $connect = new Connect("localhost","root","12345");
        $stmt = $connect->getConnect()->prepare("select *   from  activites  where   disponibilite = 1");
        $stmt->execute();
        return $stmt;
    }
};
class Admin extends Utilisateur{
    public function __construct(){
        parent:: __construct('' ,'','','admin','','');
    }
    public function crrerActivite($activite){
        $connect =  new Connect("localhost","root","12345");
        if($activite instanceof Activites){            
            $stmt = $connect->getConnect()->prepare("insert into activites  (id_admin,nom,descriptionA,capacite,date_fin,disponibilite) values (:id_admin,:nom,:descriptionA,:capacite,:date_fin,:disponibilite)");
            $id_admin = $activite->get_id_admin();
            $nom = $activite->get_nom_activite();
            $descriptionA = $activite->get_description();
            $capacite = $activite->get_capacite();
            $date_fin = $activite->get_date_fin();
            $disponibilite = $activite->get_disponibilite();
            $stmt->bindParam(":id_admin", $id_admin, PDO::PARAM_INT);
            $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
            $stmt->bindParam(":descriptionA", $descriptionA, PDO::PARAM_STR);
            $stmt->bindParam(":capacite", $capacite, PDO::PARAM_INT);
            $stmt->bindParam(":date_fin", $date_fin, PDO::PARAM_STR);
            $stmt->bindParam(":disponibilite", $disponibilite, PDO::PARAM_STR);
            $stmt->execute();
        }

    }
    public function  editActivite($activite,$newActivite){
        if(($activite instanceof Activites ) && ($newActivite instanceof Activites)){
            $connect =  new Connect("localhost","root","12345");
            $stmt = $connect->getConnect()->prepare("update activites set  nom = :nom , descriptionA = :descriptionA , capacite = :capacite , date_fin = :date_fin , disponibilite = :disponibilite where  id_activite = :id");  //id_admin = :id_admin 
        //    $id_admin = $newActivite->get_id_admin();
           $nom = $newActivite->get_nom_activite();
           $capacite = $newActivite->get_capacite();
           $date = $newActivite->get_date_fin();
           $description = $newActivite->get_description();
           $disponibilite = $newActivite->get_disponibilite();
           $id=$activite->get_id_activite();
            // $stmt->bindParam(":id_admin",$id_admin);
            $stmt->bindParam(":nom",$nom);
            $stmt->bindParam(":descriptionA",$description);
            $stmt->bindParam(":capacite",$capacite);
            $stmt->bindParam(":date_fin", $date);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":disponibilite",$disponibilite );
            $stmt->execute();
        }

    }
    public function sepprimeActivite($activite){
        $connect = new Connect("localhost","root","12345");
        if($activite instanceof Activites){
            $stmt = $connect->getConnect()->prepare("delete from activites where id_activite = :id ");
            $id =$activite->get_id_activite();
            $stmt->bindParam(":id",$id);
            $stmt->execute();
        }
    } 
    public function confirfeReservation($reservation){
        $connect = new Connect("localhost","root","12345");
        if($reservation instanceof Reservation){
            $stmt = $connect->getConnect()->prepare("update reservations set statut = 'confirmee' where id_reservation = :id ");
            $id=$reservation->getId();
            $stmt->bindParam(":id",$id);
            $stmt->execute();
        }
    }
    public function anulleReservation($reservation){
        $connect = new Connect("localhost","root","12345");
        if($reservation instanceof Reservation){
            $stmt = $connect->getConnect()->prepare("update reservations set statut = 'annulee' where id_reservation = :id ");
            $id=$reservation->getId();
            $stmt->bindParam(":id",$id);
            $stmt->execute();
        }
    }
    public function listeRservation(){
        $connect = new Connect("localhost","root","12345");
            $stmt = $connect->getConnect()->prepare("select r.* ,a.nom as activite ,u.*  from  reservations r, activites a , utilisateurs u where u.id_utilisateur = id_Membre  and  a.id_activite = r.id_activite and a.id_admin = :id");
            $id =$this->getId();
            $stmt->bindParam(":id",$id);
            $stmt->execute();
        return $stmt;
    }
    public function listActivite(){
        $connect = new Connect("localhost","root","12345");
        $stmt = $connect->getConnect()->prepare("select *   from  activites  where   id_admin = :id");
        $id =$this->getId();
        $stmt->bindParam(":id",$id);
        $stmt->execute();
    return $stmt;
    }

};

function  autandification(){
    session_start();
    if(!isset($_SESSION['role'])){
        // header("location: login.php");
        // exit;
    }elseif($_SESSION['role']=='admin'){
        header("location: home_admin.php");
        exit;
    }elseif($_SESSION['role']=='membre'){
        header("location: home_user.php");
        exit;
    }
};
function  autandificationC(){
    session_start();
    if(!isset($_SESSION['role'])){
        header("location: login.php");
        exit;
    }elseif($_SESSION['role']=='admin'){
        header("location: home_admin.php");
        exit;
    }elseif($_SESSION['role']=='membre'){
        // header("location: home_user.php");
        // exit;
    }
};
function  autandificationA(){
    session_start();
    if(!isset($_SESSION['role'])){
        header("location: login.php");
        exit;
    }elseif($_SESSION['role']=='admin'){
        // header("location: home_admin.php");
        // exit;
    }elseif($_SESSION['role']=='membre'){
        header("location: home_user.php");
        exit;
    }
};
?>
