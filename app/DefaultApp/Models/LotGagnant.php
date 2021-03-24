<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class LotGagnant extends Model
{
    protected $table="lot_gagnant";
    public $id,$date,$tirage,$lot1,$lot2,$lot3,$loto3;
    public $lotterie;

    public function rechercherParDateTirage($date,$tirage,$lotterie){
        $con=self::connection();
        $req="select *from lot_gagnant where date=:date and tirage=:tirage and lotterie=:lotterie";
        $stmt=$con->prepare($req);
        $stmt->execute(array(
            ":date"=>$date,
            ":tirage"=>$tirage,
            ":lotterie"=>$lotterie
        ));

        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

    public function add()
    {
        $lt=$this->rechercherParDateTirage($this->date,$this->tirage,$this->lotterie);
        if($lt!=null){
            return "Existe deja sur le système";
        }
        return parent::add(); // TODO: Change the autogenerated stub
    }
}