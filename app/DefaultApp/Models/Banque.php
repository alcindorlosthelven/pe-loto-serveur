<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Banque extends Model
{
 public $id,$banque,$latitude,$longitude;

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
    public function getBanque()
    {
        return $this->banque;
    }

    /**
     * @param mixed $banque
     */
    public function setBanque($banque): void
    {
        $this->banque = $banque;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }



}
