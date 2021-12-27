<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class BouleBloquer extends Model
{
    protected $table="boule_bloquer";
    public $id,$type,$boule;

    public function existe($boule)
    {
        $con=self::connection();
        $req="select *from boule_bloquer where boule=:boule";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":boule"=>$boule));
        $data=$stmt->fetchAll();
        if(count($data)>0){
            return true;
        }
        return false;
    }

    public function existeFromTable($boule,$table)
    {
        foreach ($table as $t){
            if($t->boule==$boule){
                return true;
            }
        }
        return false;
    }

    public function add()
    {
        if($this->existe($this->boule)){
            return "Boule deja bloqué sur le systeme";
        }
        return parent::add(); // TODO: Change the autogenerated stub
    }


    public function lister()
    {
        $con=self::connection();
        $req="select *from boule_bloquer where order by id asc";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }
}