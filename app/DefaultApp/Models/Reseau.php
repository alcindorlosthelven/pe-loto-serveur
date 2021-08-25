<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Reseau extends Model
{
    public $id,$nom,$id_groupe;

    public function listeReseauParGroupe($id_groupe){
        $con=self::connection();
        $req="select *from reseau where id_groupe=:id_groupe";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_groupe"=>$id_groupe));
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

}
