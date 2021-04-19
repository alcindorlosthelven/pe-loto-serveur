<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Departement extends Model
{
 public $id,$departement,$id_reseau_globale;

    public function listeDepartementParGroupe($id_groupe){
        $con=self::connection();
        $req="select departement.id,departement.departement,departement.id_reseau_globale from departement,groupe
        where groupe.id=:id_groupe and groupe.id_departement=departement.id";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_groupe"=>$id_groupe));
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

}
