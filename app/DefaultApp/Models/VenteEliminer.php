<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class VenteEliminer extends Model
{
    protected $table="vente_eliminer";
    public $id,$id_vente,$motif,$status;

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
    public function getIdVente()
    {
        return $this->id_vente;
    }

    /**
     * @param mixed $id_vente
     */
    public function setIdVente($id_vente): void
    {
        $this->id_vente = $id_vente;
    }

    /**
     * @return mixed
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * @param mixed $motif
     */
    public function setMotif($motif): void
    {
        $this->motif = $motif;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public static function existe($id_vente){
        $con=self::connection();
        $req="select *from vente_eliminer where id_vente=:id_vente";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_vente"=>$id_vente));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return true;
        }else{
            return false;
        }
    }

    public function add(){
        if(self::existe($this->id_vente)){
            return "Fiche en cours d'élimination";
        }
        return parent::add();
    }

    public static function rechercheParIdVente($id_vente){
        $con=self::connection();
        $req="select *from vente_eliminer where id_vente=:id_vente";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_vente"=>$id_vente));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }else{
           return null;
        }
    }

    public function total(){
        $con=self::connection();
        $req="select *from vente_eliminer where status='terminer'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

}
