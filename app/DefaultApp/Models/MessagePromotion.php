<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class MessagePromotion extends Model
{
    protected $table="message_promotion";
    public $id,$type,$titre,$contenue,$date,$heure;

    public function listeMessage(){
        $con=self::connection();
        $req="Select *from message_promotion where type='message'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

    public function listePromotions(){
        $con=self::connection();
        $req="Select *from message_promotion where type='promotion'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

}
