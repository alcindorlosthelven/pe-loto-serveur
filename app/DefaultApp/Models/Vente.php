<?php


namespace app\DefaultApp\Models;

use systeme\Model\Model;

class Vente extends Model
{

    public $id,$no_ticket,$id_client,$id_vendeur,$ref_pos,$tid,$sequence,$serial,$date,$heure,$paris,$tirage,$eliminer;

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
    public function getEliminer()
    {
        return $this->eliminer;
    }

    /**
     * @param mixed $eliminer
     */
    public function setEliminer($eliminer): void
    {
        $this->eliminer = $eliminer;
    }



    public function getParis()
    {
        return $this->paris;
    }

    public function setParis($paris)
    {
        $this->paris = $paris;
    }


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
    public function getNoTicket()
    {
        return $this->no_ticket;
    }

    /**
     * @param mixed $no_ticket
     */
    public function setNoTicket($no_ticket): void
    {
        $this->no_ticket = $no_ticket;
    }

    /**
     * @return mixed
     */
    public function getIdClient()
    {
        return $this->id_client;
    }

    /**
     * @param mixed $id_client
     */
    public function setIdClient($id_client): void
    {
        $this->id_client = $id_client;
    }

    /**
     * @return mixed
     */
    public function getIdVendeur()
    {
        return $this->id_vendeur;
    }

    /**
     * @param mixed $id_vendeur
     */
    public function setIdVendeur($id_vendeur): void
    {
        $this->id_vendeur = $id_vendeur;
    }

    /**
     * @return mixed
     */
    public function getRefPos()
    {
        return $this->ref_pos;
    }

    /**
     * @param mixed $ref_pos
     */
    public function setRefPos($ref_pos): void
    {
        $this->ref_pos = $ref_pos;
    }

    /**
     * @return mixed
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param mixed $tid
     */
    public function setTid($tid): void
    {
        $this->tid = $tid;
    }

    /**
     * @return mixed
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @param mixed $sequence
     */
    public function setSequence($sequence): void
    {
        $this->sequence = $sequence;
    }

    /**
     * @return mixed
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * @param mixed $serial
     */
    public function setSerial($serial): void
    {
        $this->serial = $serial;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $data
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * @param mixed $heure
     */
    public function setHeure($heure): void
    {
        $this->heure = $heure;
    }

    public function listeParis(){
        $ps=json_decode($this->paris);
        return $ps;
    }

    public function findByCritere($no_ticket,$tid,$serial,$tirage){
        $con=self::connection();
        $req="select *from vente where no_ticket=:no_ticket and tid=:tid and serial=:serial and tirage=:tirage";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":no_ticket"=>$no_ticket,":tid"=>$tid,":serial"=>$serial,":tirage"=>$tirage));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }


}