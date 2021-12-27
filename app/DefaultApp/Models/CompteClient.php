<?php

namespace app\DefaultApp\Models;

use systeme\Model\Model;

class CompteClient extends Model
{
    protected $table="compte_client";
    public $id,$id_client,$balance_jeux,$balance_retrait;

    public function rechercher($id_client){
        $con=self::connection();
        $req="select *from compte_client where id_client=:id_client";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_client"=>$id_client));
        $data=$stmt->fetchAll(\PDO::FETCH_OBJ);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

    public static function updateBalance($id_client,$montant){
        $con=self::connection();
        $req="update compte_client set balance_retrait=:balance where id_client=:id_client";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_client"=>$id_client,":balance"=>$montant));
        if($stmt->rowCount()>0){
            return "ok";
        }
        return "no";
    }

    public static function updateBalanceCredit($id_client,$montant){
        $con=self::connection();
        $req="update compte_client set balance_jeux=:balance where id_client=:id_client";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_client"=>$id_client,":balance"=>$montant));
        if($stmt->rowCount()>0){
            return "ok";
        }
        return "no";
    }

    public static function getBalance($id_client){
        $con=self::connection();
        $req="select balance_retrait from compte_client where id_client=:id_client";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_client"=>$id_client));
        $data=$stmt->fetchObject();
        return floatval($data->balance_retrait);
    }

    public static function getBalanceCredit($id_client){
        $con=self::connection();
        $req="select balance_jeux from compte_client where id_client=:id_client";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_client"=>$id_client));
        $data=$stmt->fetchObject();
        return floatval($data->balance_jeux);
    }


    public static function depot($id_client,$montant){
        if(floatval($montant)<=0){
            return "Montant invalid";
        }
        $balance=self::getBalance($id_client);
        $nbalance=floatval($balance+$montant);
        return self::updateBalance($id_client,$nbalance);
    }
    public static function depotCredit($id_client,$montant){
        if(floatval($montant)<=0){
            return "Montant invalid";
        }
        $balance=self::getBalanceCredit($id_client);
        $nbalance=floatval($balance+$montant);
        return self::updateBalanceCredit($id_client,$nbalance);
    }

    public static function retrait($id_client,$montant){
        if(floatval($montant)<=0){
            return "Montant invalid";
        }
        $balance=self::getBalance($id_client);
        $nbalance=floatval($balance-$montant);
        if($nbalance<0){
            return "Balance insufisant";
        }
        return self::updateBalance($id_client,$nbalance);
    }
    public static function retraitCredit($id_client,$montant){
        if(floatval($montant)<=0){
            return "Montant invalid";
        }
        $balance=self::getBalanceCredit($id_client);
        $nbalance=floatval($balance-$montant);
        if($nbalance<0){
            return "Balance insufisant";
        }
        return self::updateBalanceCredit($id_client,$nbalance);
    }

    public static function getInfoCompte($id_client){

        $con=self::connection();
        $req="select *from compte_client where id_client=:id_client";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_client"=>$id_client));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

}
