<?php


namespace app\DefaultApp\Models;


use Ixudra\Curl\CurlService;
use systeme\Model\Model;

class LotGagnant extends Model
{
    protected $table="lot_gagnant";
    public $id,$date,$tirage,$lot1,$lot2,$lot3,$loto3;
    public $lotterie;
    public $borlette,$loto4,$loto5,$mariaj;

    public function rechercherParDateTirage($date,$tirage){
        $con=self::connection();
        $req="select *from lot_gagnant where date=:date and tirage=:tirage";
        $stmt=$con->prepare($req);
        $stmt->execute(array(
            ":date"=>$date,
            ":tirage"=>$tirage,
        ));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

    public function add()
    {
        $lt=$this->rechercherParDateTirage($this->date,$this->tirage);
        if($lt!=null){
            return "Existe deja sur le système";
        }
        return parent::add(); // TODO: Change the autogenerated stub
    }

    /*public static function getLoto3Midi($etat="ny"){

        $curlService = new CurlService();
        $url = App::LIENMAGAYO."&game=us_".$etat."_numbers_mid";

        $resultat=$curlService->to($url)
            ->asJson()
            ->get();

        if($resultat->error==0){
            return $resultat;
            if($resultat->draw==date("Y-m-d")){

            }else{
             return null;
            }
        }else{
            return null;
        }
    }

    public static function getLoto3Soir($etat="ny"){
        $curlService = new CurlService();
        $url = App::LIENMAGAYO."&game=us_".$etat."_numbers_eve";

        $resultat=$curlService->to($url)
            ->asJson()
            ->get();

        if($resultat->error==0){
            if($resultat->draw==date("Y-m-d")){
                return $resultat;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    public static function getWin4Midi($etat="ny"){
        $curlService = new CurlService();
        $url = App::LIENMAGAYO."&game=us_".$etat."_win4_mid";

        $resultat=$curlService->to($url)
            ->asJson()
            ->get();
        if($resultat->error==0){
            return $resultat;
            if($resultat->draw==date("Y-m-d")){
                return $resultat;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    public static function getWin4Soir($etat="ny"){
        $curlService = new CurlService();
        $url = App::LIENMAGAYO."&game=us_".$etat."_win4_eve";

        $resultat=$curlService->to($url)
            ->asJson()
            ->get();

        if($resultat->error==0){
            if($resultat->draw==date("Y-m-d")){
                return $resultat;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }*/

    /*public static function getLotGagnantFromMagayoMidi($etat="ny"){
        $lg=new LotGagnant();
        $l3=self::getLoto3Midi($etat);

        if($l3!=null){
            $loto3=$l3->results;
            $lg->lot1=substr($loto3,1,2);
            $lg->loto3=substr($loto3,0,1);
            $win4=self::getWin4Midi($etat);
            if($win4!=null){
                $w4=$win4->results;
                $lg->lot2=substr($w4,0,2);
                $lg->lot3=substr($w4,2,2);
                return $lg;
            }
            return null;
        }
        return null;
    }*/
}
