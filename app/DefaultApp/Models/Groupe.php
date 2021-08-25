<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Groupe extends Model
{

    public $id,$nom,$id_departement;

    public function listeGroupeParDepartement($id_departement){
        $con=self::connection();
        $req="select *from groupe where id_departement=:id_departement";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_departement"=>$id_departement));
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

}
