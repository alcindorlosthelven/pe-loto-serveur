<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Pos extends Model
{
 public $id,$imei,$longitude,$latitude,$statut,$id_superviseur,$id_branche,$id_banque,$id_departement;

 public function rechercherParVendeur($idvendeur){
     $con=self::connection();
     $req="select *from pos_vendeur where id_vendeur=:id_vendeur limit 1";
     $stmt=$con->prepare($req);
     $stmt->execute(array(
         ":id_vendeur"=>$idvendeur
     ));
     $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
     if(count($data)>0){
         $pos=$this->findById($data[0]->id_pos);
         return $pos;
     }else{
         return null;
     }

 }

 public function updatePosition($imei,$latitude,$longitude){
     try {
         $con=self::connection();
         $req="update pos set longitude=:longitude,latitude=:latitude where imei=:imei";
         $stmt=$con->prepare($req);
         if($stmt->execute(array(":longitude"=>$longitude,":latitude"=>$latitude,":imei"=>$imei))){
             return "ok";
         }

         return "no";
     }catch (\Exception $ex){
         return $ex->getMessage();
     }
 }
}
