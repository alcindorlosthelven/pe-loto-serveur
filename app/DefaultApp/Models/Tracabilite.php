<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Tracabilite extends Model
{
    public $id,$date,$heure,$utilisateur,$action;

    public function __construct()
    {
        $this->date=date("Y-m-d");
        $this->heure=date("H:i:s");
        $this->utilisateur=\systeme\Model\Utilisateur::session_valeur();
    }

    public static function lister($date1,$date2){
        $con=self::connection();
        $req="select *from tracabilite where date between '{$date1}' and '{$date2}' order by id desc";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
