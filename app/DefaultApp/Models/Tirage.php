<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Tirage extends Model
{

    public $id,$tirage,$statut,$nom,$heure_fermeture,$heure_ouverture,$heure_rapport,$email_rapport,$site_api,$prime;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTirage()
    {
        return $this->tirage;
    }

    /**
     * @param mixed $tirage
     */
    public function setTirage($tirage): void
    {
        $this->tirage = $tirage;
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param mixed $statut
     */
    public function setStatut($statut): void
    {
        $this->statut = $statut;
    }

    public function listeEncours(){
        $con=self::connection();
        $req="select *from tirage where statut='en cours'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        return $data;
    }

    public static function rechercherParNomActif($nom){
        $con=self::connection();
        $req="select *from tirage where tirage=:tirage and statut='en cours'";
        $stmt=$con->prepare($req);

        $stmt->execute(array(
            ":tirage"=>$nom
        ));

        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

    public static function isTirageEncour2($tirage){
        $heure = date("H:i");
        $ti = Tirage::rechercherParNom($tirage);
        if ($heure >= $ti->heure_fermeture) {
            return true;
        }
        return false;
    }

    public static function isTirageEncour($tirage){
        $con=self::connection();
        $req="select *from tirage where tirage=:tirage and (statut='n/a' or statut='fermer')";
        $stmt=$con->prepare($req);
        $stmt->execute(array(
            ":tirage"=>$tirage
        ));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return false;
        }
        return true;
    }

    public static function rechercherParNom($nom){
        $con=self::connection();
        $req="select *from tirage where tirage=:tirage";
        $stmt=$con->prepare($req);
        $stmt->execute(array(
            ":tirage"=>$nom
        ));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

}
