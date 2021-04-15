<?php


namespace app\DefaultApp\Models;

use systeme\Model\Model;

class Vente extends Model
{

    public $id,$no_ticket,$id_client,$id_vendeur,$ref_pos,$tid,$sequence,$serial,$date,$heure,$paris,$tirage,$eliminer;
    public $gain,$total_gain,$payer;

    /**
     * @return mixed
     */
    public function getTirage()
    {
        return $this->tirage;
    }

    /**
     * @param mixed $tirage
     */
    public function setTirage($tirage): void
    {
        $this->tirage = $tirage;
    }

    /**
     * @return mixed
     */
    public function getEliminer()
    {
        return $this->eliminer;
    }

    /**
     * @param mixed $eliminer
     */
    public function setEliminer($eliminer): void
    {
        $this->eliminer = $eliminer;
    }



    public function getParis()
    {
        return $this->paris;
    }

    public function setParis($paris)
    {
        $this->paris = $paris;
    }


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
    public function getNoTicket()
    {
        return $this->no_ticket;
    }

    /**
     * @param mixed $no_ticket
     */
    public function setNoTicket($no_ticket): void
    {
        $this->no_ticket = $no_ticket;
    }

    /**
     * @return mixed
     */
    public function getIdClient()
    {
        return $this->id_client;
    }

    /**
     * @param mixed $id_client
     */
    public function setIdClient($id_client): void
    {
        $this->id_client = $id_client;
    }

    /**
     * @return mixed
     */
    public function getIdVendeur()
    {
        return $this->id_vendeur;
    }

    /**
     * @param mixed $id_vendeur
     */
    public function setIdVendeur($id_vendeur): void
    {
        $this->id_vendeur = $id_vendeur;
    }

    /**
     * @return mixed
     */
    public function getRefPos()
    {
        return $this->ref_pos;
    }

    /**
     * @param mixed $ref_pos
     */
    public function setRefPos($ref_pos): void
    {
        $this->ref_pos = $ref_pos;
    }

    /**
     * @return mixed
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param mixed $tid
     */
    public function setTid($tid): void
    {
        $this->tid = $tid;
    }

    /**
     * @return mixed
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @param mixed $sequence
     */
    public function setSequence($sequence): void
    {
        $this->sequence = $sequence;
    }

    /**
     * @return mixed
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * @param mixed $serial
     */
    public function setSerial($serial): void
    {
        $this->serial = $serial;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $data
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * @param mixed $heure
     */
    public function setHeure($heure): void
    {
        $this->heure = $heure;
    }

    public function listeParis(){
        $ps=json_decode($this->paris);
        foreach ($ps as $i=>$value){
            $ps[$i]->date=$this->date;
            $ps[$i]->tirage=$this->tirage;
        }
        return $ps;
    }

    public function findByCritere($no_ticket,$tid,$serial,$tirage,$id_vendeur){
        $con=self::connection();
        $req="select *from vente where no_ticket=:no_ticket and tid=:tid and serial=:serial and tirage=:tirage and id_vendeur=:id_vendeur";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":no_ticket"=>$no_ticket,":tid"=>$tid,":serial"=>$serial,":tirage"=>$tirage,":id_vendeur"=>$id_vendeur));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

    public function listeEliminer($id_vendeur=""){
        $con=self::connection();
        if($id_vendeur=="") {
            $req = "select *from vente where eliminer='oui'";
        }else{
            $req = "select *from vente where eliminer='oui' and id_vendeur='{$id_vendeur}'";
        }

        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        return $data;
    }

    public function listeNonEliminer($id_vendeur=""){
        $con=self::connection();
        if($id_vendeur==""){
            $req = "select *from vente where eliminer='non'";
        }else {
            $req = "select *from vente where eliminer='non' and id_vendeur='{$id_vendeur}'";
        }
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        return $data;
    }

    public function listeDemmandeElimination($id_vendeur=""){
        $con=self::connection();
        if($id_vendeur=="") {
            $req = "select vente.id,vente.id_vendeur,vente.id_client,vente.paris,vente.tirage,vente.no_ticket,vente.ref_pos,
        vente.tid,vente.sequence,vente.serial,vente.date,vente.heure,vente.eliminer,
        vente_eliminer.id as 'id_vente_eliminer' , vente_eliminer.motif,vente_eliminer.status
        from vente,vente_eliminer where vente.id=vente_eliminer.id_vente and vente.eliminer='non' and vente_eliminer.status='en cours'";
        }else{
            $req = "select vente.id,vente.id_vendeur,vente.id_client,vente.paris,vente.tirage,vente.no_ticket,vente.ref_pos,
        vente.tid,vente.sequence,vente.serial,vente.date,vente.heure,vente.eliminer,
        vente_eliminer.id as 'id_vente_eliminer' , vente_eliminer.motif,vente_eliminer.status
        from vente,vente_eliminer where vente.id=vente_eliminer.id_vente and vente.eliminer='non' and vente_eliminer.status='en cours'
        and vente.id_vendeur='{$id_vendeur}'";
        }
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        return $data;
    }

    public  function findAll($id_vendeur="")
    {
        if($id_vendeur==""){
            $con=self::connection();
            $req="select *from vente";
            $stmt=$con->prepare($req);
            $stmt->execute();
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            return $data;
        }
        return parent::findAll(); // TODO: Change the autogenerated stub
    }

    public static function listeParTirageDate($date,$tirage,$id_vendeur="")
    {
        $con=self::connection();
        if($id_vendeur==""){
            $req="select *from vente where date=:date and tirage=:tirage and eliminer='non'";
            $stmt=$con->prepare($req);
            $stmt->execute(array(
                ":date"=>$date,
                ":tirage"=>$tirage
            ));
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            return $data;
        }else{
            $req="select *from vente where date=:date and tirage=:tirage and eliminer='non' and id_vendeur=:id_vendeur";
            $stmt=$con->prepare($req);
            $stmt->execute(array(
                ":date"=>$date,
                ":tirage"=>$tirage,
                ":id_vendeur"=>$id_vendeur
            ));
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            return $data;
        }
    }

    public static function getBilletGagnant($date,$tirage,$id_vendeur=""){
        /*$listeVenteGagnant=array();
        $lotGagnant=new LotGagnant();
        $lg=$lotGagnant->rechercherParDateTirage($date,$tirage);
        if($id_vendeur==""){
            $listeVente=Vente::listeParTirageDate($date,$tirage);
        }else{
            $listeVente=Vente::listeParTirageDate($date,$tirage,$id_vendeur);
        }

        foreach ($listeVente as $index=>$v){
            $gain="non";
            $totalGain=0;
            $paris=json_decode($v->paris);
            //parcourir list des paris pour voir les gagnant
            foreach ($paris as $i=>$p){
                //gplot1
                if($p->pari==$lg->lot1){
                    $gain='oui';
                    $paris[$i]->lot="lot1";
                    $paris[$i]->montant=$p->mise * 10;
                    $totalGain+=$p->mise * 10;
                }
                //gplot2
                if($p->pari==$lg->lot2){
                    $gain='oui';
                    $paris[$i]->lot="lot2";
                    $paris[$i]->montant=$p->mise * 4;
                    $totalGain+=$p->mise * 4;
                }
                //gplot3
                if($p->pari==$lg->lot3){
                    $gain='oui';
                    $paris[$i]->lot="lot3";
                    $paris[$i]->montant=$p->mise * 2;
                    $totalGain+=$p->mise * 2;
                }
                //gploto3
                if($p->pari==$lg->loto3){
                    $gain='oui';
                    $paris[$i]->lot="loto3";
                    $paris[$i]->montant=$p->mise * 100;
                    $totalGain+=$p->mise * 100;
                }
            }

            $listeVente[$index]->paris=json_encode($paris);
            $listeVente[$index]->total_gain=$totalGain;
            $listeVente[$index]->gain=$gain;
            if($gain=='oui'){
                array_push($listeVenteGagnant,$v);
            }
        }
        return $listeVenteGagnant;*/
        $con=self::connection();
        if($id_vendeur==""){
            $req="select *from vente where date=:date and tirage=:tirage and gain='oui' and payer='non'";
            $stmt=$con->prepare($req);
            $stmt->execute(
                array(
                    ":date"=>$date,
                    ":tirage"=>$tirage
                )
            );
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            return $data;
        }else{
            $req="select *from vente where date=:date and tirage=:tirage and gain='oui' and payer='non' and id_vendeur=:id_vendeur";
            $stmt=$con->prepare($req);
            $stmt->execute(array(
                ":date"=>$date,
                ":tirage"=>$tirage,
                ":id_vendeur"=>$id_vendeur
            ));
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            return $data;
        }
    }

    public static function getBilletGagnantPayer($date,$tirage,$id_vendeur=""){
        $con=self::connection();
        if($id_vendeur==""){
            $req="select *from vente where date=:date and tirage=:tirage and gain='oui' and payer='oui'";
            $stmt=$con->prepare($req);
            $stmt->execute(
                array(
                    ":date"=>$date,
                    ":tirage"=>$tirage
                )
            );
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            return $data;
        }else{
            $req="select *from vente where date=:date and tirage=:tirage and gain='oui' and payer='oui' and id_vendeur=:id_vendeur";
            $stmt=$con->prepare($req);
            $stmt->execute(array(
                ":date"=>$date,
                ":tirage"=>$tirage,
                ":id_vendeur"=>$id_vendeur
            ));
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            return $data;
        }
    }

    public static function getBilletGagnantTout($date,$tirage,$id_vendeur=""){
        $con=self::connection();
        if($id_vendeur==""){
            $req="select *from vente where date=:date and tirage=:tirage and gain='oui'";
            $stmt=$con->prepare($req);
            $stmt->execute(
                array(
                    ":date"=>$date,
                    ":tirage"=>$tirage
                )
            );
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            return $data;
        }else{
            $req="select *from vente where date=:date and tirage=:tirage and gain='oui' and id_vendeur=:id_vendeur";
            $stmt=$con->prepare($req);
            $stmt->execute(array(
                ":date"=>$date,
                ":tirage"=>$tirage,
                ":id_vendeur"=>$id_vendeur
            ));
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            return $data;
        }
    }

    public static function updateBilletForLotGagnant($date,$tirage){
        $lotGagnant=new LotGagnant();
        $lg=$lotGagnant->rechercherParDateTirage($date,$tirage);
        if($lg!=null) {
            $borlette=json_decode($lg->borlette);
            $mariaj=json_decode($lg->mariaj);
            $loto3=$lg->loto3;
            $loto4=json_decode($lg->loto4);
            $loto5=json_decode($lg->loto5);

            $listeVente = Vente::listeParTirageDate($date, $tirage);

            foreach ($listeVente as $index => $v) {
                $gain = "non";
                $totalGain = 0;
                $paris = json_decode($v->paris);
                //parcourir list des paris pour voir les gagnant

                foreach ($paris as $i => $p) {
                    $cj = new CodeJeux();
                    $cj = $cj->findByCode(substr($p->codeJeux,0,2));
                    $prime = $cj->gagne;

                    if ($p->pari == $borlette->lot1) {
                        if (stristr($prime, "|")) {
                            $pt = explode("|", $prime);
                            $pt1 = $pt[0];
                            $gain = 'oui';
                            $paris[$i]->lot = "lot1";
                            $paris[$i]->montant = $p->mise * $pt1;
                            $totalGain += $p->mise * $pt1;
                            $paris[$i]->gain=$gain;
                        }
                    }

                    //gplot2
                    if ($p->pari == $borlette->lot2) {
                        if (stristr($prime, "|")) {
                            $pt = explode("|", $prime);
                            $pt2 = $pt[1];
                            $gain = 'oui';
                            $paris[$i]->lot = "lot2";
                            $paris[$i]->montant = $p->mise * $pt2;
                            $totalGain += $p->mise * $pt2;
                            $paris[$i]->gain=$gain;
                        }
                    }

                    //gplot3
                    if ($p->pari == $borlette->lot3) {
                        if (stristr($prime, "|")) {
                            $pt = explode("|", $prime);
                            $pt3 = $pt[2];
                            $gain = 'oui';
                            $paris[$i]->lot = "lot3";
                            $paris[$i]->montant = $p->mise * $pt3;
                            $totalGain += $p->mise * $pt3;
                            $paris[$i]->gain=$gain;
                        }
                    }

                    //gploto3
                    if ($p->pari == $loto3) {
                        $gain = 'oui';
                        $paris[$i]->lot = "loto3";
                        $paris[$i]->montant = $p->mise * $prime;
                        $totalGain += $p->mise * $prime;
                        $paris[$i]->gain=$gain;
                    }


                    //loto4
                    if($p->pari == $loto4->option1){
                        $gain = 'oui';
                        $paris[$i]->lot = "lotto 4 option 1";
                        $paris[$i]->montant = $p->mise * $prime;
                        $totalGain += $p->mise * $prime;
                        $paris[$i]->gain=$gain;
                    }

                    if($p->pari == $loto4->option2){
                        $gain = 'oui';
                        $paris[$i]->lot = "lotto 4 option 2";
                        $paris[$i]->montant = $p->mise * $prime;
                        $totalGain += $p->mise * $prime;
                        $paris[$i]->gain=$gain;
                    }

                    if($p->pari == $loto4->option3){
                        $gain = 'oui';
                        $paris[$i]->lot = "lotto 4 option 3";
                        $paris[$i]->montant = $p->mise * $prime;
                        $totalGain += $p->mise * $prime;
                        $paris[$i]->gain=$gain;
                    }
                    //fin loto4

                    //loto5
                    if($p->pari == $loto5->option1){
                        $gain = 'oui';
                        $paris[$i]->lot = "lotto 5 option 1";
                        $paris[$i]->montant = $p->mise * $prime;
                        $totalGain += $p->mise * $prime;
                        $paris[$i]->gain=$gain;
                    }

                    if($p->pari == $loto5->option2){
                        $gain = 'oui';
                        $paris[$i]->lot = "lotto 5 option 2";
                        $paris[$i]->montant = $p->mise * $prime;
                        $totalGain += $p->mise * $prime;
                        $paris[$i]->gain=$gain;
                    }

                    if($p->pari == $loto5->option3){
                        $gain = 'oui';
                        $paris[$i]->lot = "lotto 5 option 3";
                        $paris[$i]->montant = $p->mise * $prime;
                        $totalGain += $p->mise * $prime;
                        $paris[$i]->gain=$gain;
                    }
                    //fin loto5

                    //mariaj
                    if(in_array($p->pari,$mariaj)){
                        if(stristr($p->pari,"*") and strlen($p->pari)==5) {
                            $gain = 'oui';
                            $paris[$i]->lot = "mariaj";
                            $paris[$i]->montant = $p->mise * $prime;
                            $totalGain += $p->mise * $prime;
                            $paris[$i]->gain = $gain;
                        }
                    }
                    //fin mariaj

                }

                $listeVente[$index]->paris = json_encode($paris);
                $listeVente[$index]->total_gain = $totalGain;
                $listeVente[$index]->gain = $gain;
                $listeVente[$index]->payer = 'non';
                if ($gain == "oui") {
                    $listeVente[$index]->update();
                }
            }
        }
    }

    public function total(){
        $con=self::connection();
        $req="select *from vente where eliminer='non'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public  function listeParPos($imei)
    {
            $con=self::connection();
            $req="select *from vente where tid=:imei";
            $stmt=$con->prepare($req);
            $stmt->execute(array(":imei"=>$imei));
            return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

    public function listerParVendeurDateTirage($id_vendeur,$date,$tirage){
        $con=self::connection();
        $req="select *from vente where date=:date and id_vendeur=:id_vendeur and tirage=:tirage and eliminer='non'";
        $stmt=$con->prepare($req);
        $stmt->execute(array(
            ":date"=>$date,
            ":id_vendeur"=>$id_vendeur,
            ":tirage"=>$tirage
        ));

        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

    public function listerParVendeurDate($id_vendeur,$date){
        $con=self::connection();
        $req="select *from vente where date=:date and id_vendeur=:id_vendeur and eliminer='non'";
        $stmt=$con->prepare($req);
        $stmt->execute(array(
            ":date"=>$date,
            ":id_vendeur"=>$id_vendeur
        ));

        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

    public static function listeParisParDate($date1,$date2,$tirage,$type_jeux="")
    {

            $code=substr($type_jeux,0,2);
            $paris=array();
            $con=self::connection();
            $req="select *from vente where date between '$date1' and '$date2' and tirage=:tirage and eliminer='non'";
            $stmt=$con->prepare($req);
            $stmt->execute(array(
                ":tirage"=>$tirage
            ));
            $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
            if(count($data)>0){
                foreach ($data as $v){
                    $p=$v->listeParis();
                    if($type_jeux!==""){
                        foreach ($p as $i=>$value){
                            if(substr($value->codeJeux,0,2)!==$code){
                                unset($p[$i]);
                            }
                        }
                    }
                    $paris=array_merge($paris,$p);
                }
            }
            return $paris;
    }
}
