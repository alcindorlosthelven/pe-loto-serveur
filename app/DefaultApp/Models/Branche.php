<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Branche extends Model
{
 public $id,$branche;

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
    public function getBranche()
    {
        return $this->branche;
    }

    /**
     * @param mixed $branche
     */
    public function setBranche($branche): void
    {
        $this->branche = $branche;
    }

}
