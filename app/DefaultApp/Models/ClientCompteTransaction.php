<?php

namespace app\DefaultApp\Models;

use systeme\Model\Model;

class ClientCompteTransaction extends Model
{
    protected $table="client_compte_transaction";
    public $id,$id_compte,$type,$date,$heure,$montant,$montant_avant,$montant_apres,$message;

    public static function listeByCompte($num){
        $con=self::connection();
        $req="select *from client_compte_transaction where id_compte=:id_compte order by id desc";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":id_compte"=>$num));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        return $data;
    }

    public static function listeByDate($debut,$fin,$type){
        $con=self::connection();
            if ($type == "tout") {
                $req = "select *from client_compte_transaction where date between '{$debut}' and '{$fin}' order by id desc";
            } else {
                $req = "select *from client_compte_transaction where date between '{$debut}' and '{$fin}' and type='{$type}' order by id desc";
            }
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        return $data;
    }

    public static function listeByDate1($debut,$fin,$type,$id_compte){
        $con=self::connection();
        if ($type == "tout") {
            $req = "select *from client_compte_transaction where date between '{$debut}' and '{$fin}' and id_compte='{$id_compte}' order by id desc";
        } else {
            $req = "select *from client_compte_transaction where date between '{$debut}' and '{$fin}' and id_compte='{$id_compte}' and type='{$type}' order by id desc";
        }
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        return $data;
    }

    public static function totalDepot($debut,$fin,$id_client){
        $infoCompte=CompteClient::getInfoCompte($id_client);
        $id_compte=$infoCompte->id;
        $con=self::connection();
        $req="select sum(montant) as total from client_compte_transaction where id_compte='{$id_compte}' and date between '{$debut}' and '{$fin}' and type='depot'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetch(\PDO::FETCH_OBJ);
        return floatval($data->total);
    }

    public static function totalRetrait($debut,$fin,$id_client){
        $infoCompte=CompteClient::getInfoCompte($id_client);
        $id_compte=$infoCompte->id;
        $con=self::connection();
        $req="select sum(montant) as total from client_compte_transaction where id_compte='{$id_compte}' and date between '{$debut}' and '{$fin}' and type='retrait'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetch(\PDO::FETCH_OBJ);
        return floatval($data->total);
    }


}
