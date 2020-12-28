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

}