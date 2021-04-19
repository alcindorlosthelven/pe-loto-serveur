<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Groupe extends Model
{

    public $id,$nom,$id_departement;

    public function listeGroupeParReseau($id_reseau){
        $con=self::connection();
        $req="select groupe.id,groupe.nom,groupe.id_departement from groupe,reseau where reseau.id=:id_reseau and
        groupe.id=reseau.id_groupe";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_reseau"=>$id_reseau));
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

}
