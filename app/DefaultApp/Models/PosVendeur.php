<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class PosVendeur extends Model
{
    protected $table = "pos_vendeur";
    public $id, $id_vendeur, $id_pos,$pourcentage;

    public static function rechercherParVendeur($id_vendeur){
        $con=self::connection();
        $req="select *from pos_vendeur where id_vendeur=:id_vendeur";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_vendeur"=>$id_vendeur));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }else{
            return null;
        }
    }

    public static function rechercherParPos($id_pos){
        $con=self::connection();
        $req="select *from pos_vendeur where id_pos=:id_pos";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_pos"=>$id_pos));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }else{
            return null;
        }
    }

}
