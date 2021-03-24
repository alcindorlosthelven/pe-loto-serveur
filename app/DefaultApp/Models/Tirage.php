<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Tirage extends Model
{

    public $id,$tirage,$statut;

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


}