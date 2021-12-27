<?php

namespace app\DefaultApp\Models;

use systeme\Model\Model;

class PosLimiteTirage extends Model
{
    protected $table = "pos_limite_tirage";
    public $id, $id_pos, $tirage, $limite;

    public static function getLimite($pos,$tirage){
     $con=self::connection();
     $req="select *from pos_limite_tirage where id_pos='{$pos}' and tirage='{$tirage}'";
     $stmt=$con->prepare($req);
     $stmt->execute();
     $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
     if(count($data)>0){
         return $data[0]->limite;
     }
     return null;
    }

    public static function rechercher($pos,$tirage){
        $con=self::connection();
        $req="select *from pos_limite_tirage where id_pos='{$pos}' and tirage='{$tirage}'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

    public function add()
    {
        return parent::add(); // TODO: Change the autogenerated stub
    }
    public function findAll()
    {
        $con=self::connection();
        $req="select *From pos_limite_tirage";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }


}