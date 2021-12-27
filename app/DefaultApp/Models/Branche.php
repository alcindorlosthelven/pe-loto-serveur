<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Branche extends Model
{
    public $id, $branche,$id_supperviseur,$addresse,$telephone,$longitude,$latitude;

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

    public function getDefaultBranche(){
        $con=self::connection();
        $req="select *from branche where branche='client'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }else{
            return null;
        }
    }

    public function ajouter(){
        $con=self::connection();
        $req="insert into branche (id,id_supperviseur,branche) value ('{$this->id}','{$this->id_supperviseur}','{$this->branche}')";
        $stmt=$con->prepare($req);
        if($stmt->execute()){
            return "ok";
        }

        return "no";
    }

}
