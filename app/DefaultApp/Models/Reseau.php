<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Reseau extends Model
{
    public $id,$nom,$id_groupe;

    public function listeReseauParBranche($id_branche){
        $con=self::connection();
        $req="select reseau.id,reseau.nom,reseau.id_groupe from reseau,branche where branche.id=:id_branche and
        reseau.id=branche.id_reseau";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_branche"=>$id_branche));
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

}
