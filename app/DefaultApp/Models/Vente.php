<?php


namespace app\DefaultApp\Models;

use app\DefaultApp\DefaultApp;
use stdClass;
use systeme\Model\Model;

class Vente extends Model
{

    public $id, $no_ticket, $id_client, $id_vendeur, $ref_pos, $tid, $sequence, $serial, $date, $heure, $paris, $tirage, $eliminer;
    public $gain, $total_gain, $payer, $id_branche, $id_superviseur, $id_pos;

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

    public function findByTicket($noticket)
    {
        $con = self::connection();
        $req = "select *from vente where no_ticket=:ticket";
        $stmt = $con->prepare($req);
        $stmt->execute(array(
            ":ticket" => $noticket
        ));

        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        if (count($data) > 0) {
            return $data[0];
        }

        return null;
    }

    public function findByTicketVendeur($noticket, $id_vendeur)
    {
        $con = self::connection();
        $req = "select *from vente where no_ticket=:ticket and id_vendeur=:id_vendeur";
        $stmt = $con->prepare($req);
        $stmt->execute(array(
            ":ticket" => $noticket,
            ":id_vendeur" => $id_vendeur
        ));
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        if (count($data) > 0) {
            return $data[0];
        }
        return null;
    }

    public function listeParis()
    {
        $ps = json_decode($this->paris);
        foreach ($ps as $i => $value) {
            $ps[$i]->date = $this->date;
            $ps[$i]->tirage = $this->tirage;
        }
        return $ps;
    }

    public function findByCritere($no_ticket, $tid, $serial, $tirage, $id_vendeur)
    {
        $con = self::connection();
        $req = "select *from vente where no_ticket=:no_ticket and tid=:tid and serial=:serial and tirage=:tirage and id_vendeur=:id_vendeur
        and tire<>'oui'";
        $stmt = $con->prepare($req);
        $stmt->execute(array(":no_ticket" => $no_ticket, ":tid" => $tid, ":serial" => $serial, ":tirage" => $tirage, ":id_vendeur" => $id_vendeur));
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        if (count($data) > 0) {
            return $data[0];
        }
        return null;
    }

    public function listeEliminer($id_vendeur = "")
    {
        $con = self::connection();
        if ($id_vendeur == "") {
            $req = "select *from vente where eliminer='oui'";
        } else {
            $req = "select *from vente where eliminer='oui' and id_vendeur='{$id_vendeur}'";
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        return $data;
    }

    public function listeNonEliminer($id_vendeur = "", $date1 = "", $date2 = "")
    {
        $con = self::connection();
        if ($id_vendeur == "") {
            if ($date1 == '') {
                $req = "select *from vente where eliminer='non'";
            } else {
                $req = "select *from vente where eliminer='non' and date between '{$date1}' and '{$date2}'";
            }
        } else {
            if($date1=='') {
                $req = "select *from vente where eliminer='non' and id_vendeur='{$id_vendeur}'";
            }else{
                $req = "select *from vente where eliminer='non' and id_vendeur='{$id_vendeur}' and date between '{$date1}' and '{$date2}'";
            }
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        return $data;
    }

    public static function listeDemmandeElimination($id_vendeur = "")
    {
        $con = self::connection();
        if ($id_vendeur == "") {
            $req = "select vente.id,vente.id_vendeur,vente.id_client,vente.paris,vente.tirage,vente.no_ticket,vente.ref_pos,
        vente.tid,vente.sequence,vente.serial,vente.date,vente.heure,vente.eliminer,
        vente_eliminer.id as 'id_vente_eliminer' , vente_eliminer.motif,vente_eliminer.status
        from vente,vente_eliminer where vente.id=vente_eliminer.id_vente and vente.eliminer='non' and vente_eliminer.status='en cours'
        and vente.tire<>'oui'";
        } else {
            $req = "select vente.id,vente.id_vendeur,vente.id_client,vente.paris,vente.tirage,vente.no_ticket,vente.ref_pos,
        vente.tid,vente.sequence,vente.serial,vente.date,vente.heure,vente.eliminer,
        vente_eliminer.id as 'id_vente_eliminer' , vente_eliminer.motif,vente_eliminer.status
        from vente,vente_eliminer where vente.id=vente_eliminer.id_vente and vente.eliminer='non' and vente_eliminer.status='en cours'
        and vente.id_vendeur='{$id_vendeur}' and vente.tire <> 'oui'";
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        foreach ($data as $i => $v) {
            $ve = new Vendeur();
            $ve = $ve->findById($v->id_vendeur);
            $data[$i]->vendeur = $ve;

            $paris = json_decode($v->paris);
            //parcourir list des paris pour voir les gagnant
            $montant = 0;
            foreach ($paris as $ii => $p) {
                $montant += $p->mise;
            }
            $data[$i]->montant = $montant;
        }
        return $data;
    }

    public function findAll($id_vendeur = "")
    {
        if ($id_vendeur == "") {
            $con = self::connection();
            $req = "select *from vente";
            $stmt = $con->prepare($req);
            $stmt->execute();
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            return $data;
        }
        return parent::findAll(); // TODO: Change the autogenerated stub
    }

    public static function listeParTirageDate($date, $tirage, $id_vendeur = "")
    {
        $con = self::connection();
        if ($id_vendeur == "") {
            $req = "select *from vente where date=:date and tirage=:tirage and eliminer='non'";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":date" => $date,
                ":tirage" => $tirage
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            return $data;
        } else {
            $req = "select *from vente where date=:date and tirage=:tirage and eliminer='non' and id_vendeur=:id_vendeur";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":date" => $date,
                ":tirage" => $tirage,
                ":id_vendeur" => $id_vendeur
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            return $data;
        }
    }

    public static function getBilletGagnant($date, $tirage, $id_vendeur = "")
    {
        $con = self::connection();
        if ($id_vendeur == "") {
            $req = "select *from vente where date=:date and tirage=:tirage and gain='oui' and payer='non'";
            $stmt = $con->prepare($req);
            $stmt->execute(
                array(
                    ":date" => $date,
                    ":tirage" => $tirage
                )
            );
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            return $data;
        } else {
            $req = "select *from vente where date=:date and tirage=:tirage and gain='oui' and payer='non' and id_vendeur=:id_vendeur";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":date" => $date,
                ":tirage" => $tirage,
                ":id_vendeur" => $id_vendeur
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            return $data;
        }
    }

    public static function getBilletGagnantPayer($date, $tirage, $id_vendeur = "")
    {
        $con = self::connection();
        if ($id_vendeur == "") {
            $req = "select *from vente where date=:date and tirage=:tirage and gain='oui' and payer='oui'";
            $stmt = $con->prepare($req);
            $stmt->execute(
                array(
                    ":date" => $date,
                    ":tirage" => $tirage
                )
            );
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            return $data;
        } else {
            $req = "select *from vente where date=:date and tirage=:tirage and gain='oui' and payer='oui' and id_vendeur=:id_vendeur";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":date" => $date,
                ":tirage" => $tirage,
                ":id_vendeur" => $id_vendeur
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            return $data;
        }
    }

    public static function getBilletGagnantTout($date, $tirage, $id_vendeur = "")
    {
        $con = self::connection();
        if ($id_vendeur == "") {
            $req = "select *from vente where date=:date and tirage=:tirage and gain='oui'";
            $stmt = $con->prepare($req);
            $stmt->execute(
                array(
                    ":date" => $date,
                    ":tirage" => $tirage
                )
            );
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            return $data;
        } else {
            $req = "select *from vente where date=:date and tirage=:tirage and gain='oui' and id_vendeur=:id_vendeur";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":date" => $date,
                ":tirage" => $tirage,
                ":id_vendeur" => $id_vendeur
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            return $data;
        }
    }

    private static function getPrimeFromTable($table, $code)
    {
        foreach ($table as $t) {
            if ($t->code == $code) {
                return $t->prime;
            }
        }
    }

    public static function updateBilletForLotGagnant($date, $tirage)
    {
        $lotGagnant = new LotGagnant();
        $lg = $lotGagnant->rechercherParDateTirage($date, $tirage);

        if ($lg != null) {
            $borlette = json_decode($lg->borlette);
            $mariaj = json_decode($lg->mariaj);
            $mariaj_gratis = json_decode($lg->mariaj);
            $loto3 = $lg->loto3;
            $loto4 = json_decode($lg->loto4);
            $loto5 = json_decode($lg->loto5);
            $listeVente = Vente::listeParTirageDate($date, $tirage);

            foreach ($listeVente as $index => $v) {
                /*$id_pos = $v->id_pos;
                $pos = new Pos();
                $pos = $pos->findById($id_pos);
                $primes = $pos->prime;*/
                $id_branche = $v->id_branche;
                $branche = new Branche();
                $branche = $branche->findById($id_branche);
                $primes = $branche->prime;

                $gain = "non";
                $totalGain = 0;
                $paris = json_decode($v->paris);
                $primesT = json_decode($primes);

                //parcourir list des paris pour voir les gagnant
                foreach ($paris as $i => $p) {

                    if (strlen($primes) < 10) {
                        $cj = new CodeJeux();
                        $cj = $cj->findByCode(explode(":", $p->codeJeux)[0]);
                        $prime = $cj->gagne;
                    } else {
                        $prime = self::getPrimeFromTable($primesT, explode(":", $p->codeJeux)[0]);
                    }

                    //borlette
                    if (explode(":", $p->codeJeux)[0] == 20) {
                        if (stristr($prime, "|")) {
                            $pt = explode("|", $prime);
                            $pt1 = $pt[0];
                            $pt2 = $pt[1];
                            $pt3 = $pt[2];
                        } else {
                            $pt1 = 50;
                            $pt2 = 20;
                            $pt3 = 10;
                        }

                        if ($p->pari == $borlette->lot1) {
                            $gain = 'oui';
                            $paris[$i]->lot = "lot1";
                            $paris[$i]->montant = $p->mise * $pt1;
                            $totalGain += $p->mise * $pt1;
                            $paris[$i]->gain = $gain;
                        } elseif ($p->pari == $borlette->lot2) {
                            $gain = 'oui';
                            $paris[$i]->lot = "lot2";
                            $paris[$i]->montant = $p->mise * $pt2;
                            $totalGain += $p->mise * $pt2;
                            $paris[$i]->gain = $gain;
                        } elseif ($p->pari == $borlette->lot3) {
                            $gain = 'oui';
                            $paris[$i]->lot = "lot3";
                            $paris[$i]->montant = $p->mise * $pt3;
                            $totalGain += $p->mise * $pt3;
                            $paris[$i]->gain = $gain;
                        } else {
                            $paris[$i]->lot = "";
                            $paris[$i]->montant = 0;
                            $paris[$i]->gain = "non";
                        }
                    }
                    //fin borlette

                    //lotto3
                    if (explode(":", $p->codeJeux)[0] == 30) {
                        if ($p->pari == $loto3) {
                            $gain = 'oui';
                            $paris[$i]->lot = "loto3";
                            $paris[$i]->montant = $p->mise * $prime;
                            $totalGain += $p->mise * $prime;
                            $paris[$i]->gain = $gain;
                        } else {
                            $paris[$i]->lot = "";
                            $paris[$i]->montant = 0;
                            $paris[$i]->gain = "non";
                        }
                    }
                    //fin lotto3

                    //lotto4
                    if (explode(":", $p->codeJeux)[0] >= 41 && explode(":", $p->codeJeux)[0] <= 43) {

                        if (explode(":", $p->codeJeux)[0] == 41) {
                            if ($p->pari == $loto4->option1) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 4 option 1";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        } elseif (explode(":", $p->codeJeux)[0] == 42) {
                            if ($p->pari == $loto4->option2) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 4 option 2";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        } elseif (explode(":", $p->codeJeux)[0] == 43) {
                            if ($p->pari === $loto4->option3) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 4 option 3";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }

                    }

                    //lotto5
                    if (explode(":", $p->codeJeux)[0] >= 51 && explode(":", $p->codeJeux)[0] <= 53) {

                        if (explode(":", $p->codeJeux)[0] == 51) {
                            if ($p->pari == $loto5->option1) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 5 option 1";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }

                        if (explode(":", $p->codeJeux)[0] == 52) {
                            if ($p->pari == $loto5->option2) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 5 option 2";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }

                        if (explode(":", $p->codeJeux)[0] == 53) {
                            if ($p->pari == $loto5->option3) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 5 option 3";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }
                    }

                    //mariage
                    if (explode(":", $p->codeJeux)[0] == 40) {
                        if (stristr($p->pari, "*") and strlen($p->pari) == 5) {
                            if (in_array($p->pari, $mariaj)) {
                                $gain = 'oui';
                                $paris[$i]->lot = "mariaj";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }
                    }

                    //mariage gratuit
                    if (explode(":", $p->codeJeux)[0] == 44) {
                        if (stristr($p->pari, "*") and strlen($p->pari) == 5) {
                            if (in_array($p->pari, $mariaj)) {
                                $gain = 'oui';
                                $paris[$i]->lot = "mariaj gratis";
                                $paris[$i]->montant = 1 * $prime;
                                $totalGain += 1 * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }
                    }

                }
                if ($gain == "oui") {
                    $listeVente[$index]->paris = json_encode($paris);
                    $listeVente[$index]->total_gain = $totalGain;
                    $listeVente[$index]->gain = $gain;
                    $listeVente[$index]->payer = 'non';
                    $listeVente[$index]->tire = "oui";
                } else {
                    $listeVente[$index]->paris = json_encode($paris);
                    $listeVente[$index]->total_gain = "0";
                    $listeVente[$index]->gain = "non";
                    $listeVente[$index]->payer = 'non';
                    $listeVente[$index]->tire = "oui";
                }
                $listeVente[$index]->update();
            }

        }
    }

    public static function updateBilletForLotGagnantModifier($date, $tirage)
    {
        $lotGagnant = new LotGagnant();
        $lg = $lotGagnant->rechercherParDateTirage($date, $tirage);

        if ($lg != null) {
            $borlette = json_decode($lg->borlette);
            $mariaj = json_decode($lg->mariaj);
            $mariaj_gratis = json_decode($lg->mariaj);
            $loto3 = $lg->loto3;
            $loto4 = json_decode($lg->loto4);
            $loto5 = json_decode($lg->loto5);
            $listeVente = Vente::listeParTirageDate($date, $tirage);

            foreach ($listeVente as $index => $v) {
                /*$id_pos = $v->id_pos;
                $pos = new Pos();
                $pos = $pos->findById($id_pos);
                $primes = $pos->prime;*/
                $id_branche = $v->id_branche;
                $branche = new Branche();
                $branche = $branche->findById($id_branche);
                $primes = $branche->prime;

                $gain = "non";
                $totalGain = 0;
                $paris = json_decode($v->paris);
                $primesT = json_decode($primes);

                //parcourir list des paris pour voir les gagnant
                foreach ($paris as $i => $p) {

                    if (strlen($primes) < 10) {
                        $cj = new CodeJeux();
                        $cj = $cj->findByCode(explode(":", $p->codeJeux)[0]);
                        $prime = $cj->gagne;
                    } else {
                        $prime = self::getPrimeFromTable($primesT, explode(":", $p->codeJeux)[0]);
                    }

                    //borlette
                    if (explode(":", $p->codeJeux)[0] == 20) {
                        if (stristr($prime, "|")) {
                            $pt = explode("|", $prime);
                            $pt1 = $pt[0];
                            $pt2 = $pt[1];
                            $pt3 = $pt[2];
                        } else {
                            $pt1 = 50;
                            $pt2 = 20;
                            $pt3 = 10;
                        }

                        if ($p->pari == $borlette->lot1) {
                            $gain = 'oui';
                            $paris[$i]->lot = "lot1";
                            $paris[$i]->montant = $p->mise * $pt1;
                            $totalGain += $p->mise * $pt1;
                            $paris[$i]->gain = $gain;
                        } elseif ($p->pari == $borlette->lot2) {
                            $gain = 'oui';
                            $paris[$i]->lot = "lot2";
                            $paris[$i]->montant = $p->mise * $pt2;
                            $totalGain += $p->mise * $pt2;
                            $paris[$i]->gain = $gain;
                        } elseif ($p->pari == $borlette->lot3) {
                            $gain = 'oui';
                            $paris[$i]->lot = "lot3";
                            $paris[$i]->montant = $p->mise * $pt3;
                            $totalGain += $p->mise * $pt3;
                            $paris[$i]->gain = $gain;
                        } else {
                            $paris[$i]->lot = "";
                            $paris[$i]->montant = 0;
                            $paris[$i]->gain = "non";
                        }
                    }
                    //fin borlette

                    //lotto3
                    if (explode(":", $p->codeJeux)[0] == 30) {
                        if ($p->pari == $loto3) {
                            $gain = 'oui';
                            $paris[$i]->lot = "loto3";
                            $paris[$i]->montant = $p->mise * $prime;
                            $totalGain += $p->mise * $prime;
                            $paris[$i]->gain = $gain;
                        } else {
                            $paris[$i]->lot = "";
                            $paris[$i]->montant = 0;
                            $paris[$i]->gain = "non";
                        }
                    }
                    //fin lotto3

                    //lotto4
                    if (explode(":", $p->codeJeux)[0] >= 41 && explode(":", $p->codeJeux)[0] <= 43) {

                        if (explode(":", $p->codeJeux)[0] == 41) {
                            if ($p->pari == $loto4->option1) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 4 option 1";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        } elseif (explode(":", $p->codeJeux)[0] == 42) {
                            if ($p->pari == $loto4->option2) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 4 option 2";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        } elseif (explode(":", $p->codeJeux)[0] == 43) {
                            if ($p->pari === $loto4->option3) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 4 option 3";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }

                    }

                    //lotto5
                    if (explode(":", $p->codeJeux)[0] >= 51 && explode(":", $p->codeJeux)[0] <= 53) {

                        if (explode(":", $p->codeJeux)[0] == 51) {
                            if ($p->pari == $loto5->option1) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 5 option 1";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }

                        if (explode(":", $p->codeJeux)[0] == 52) {
                            if ($p->pari == $loto5->option2) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 5 option 2";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }

                        if (explode(":", $p->codeJeux)[0] == 53) {
                            if ($p->pari == $loto5->option3) {
                                $gain = 'oui';
                                $paris[$i]->lot = "lotto 5 option 3";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }
                    }

                    //mariage
                    if (explode(":", $p->codeJeux)[0] == 40) {
                        if (stristr($p->pari, "*") and strlen($p->pari) == 5) {
                            if (in_array($p->pari, $mariaj)) {
                                $gain = 'oui';
                                $paris[$i]->lot = "mariaj";
                                $paris[$i]->montant = $p->mise * $prime;
                                $totalGain += $p->mise * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }
                    }

                    //mariage gratuit
                    if (explode(":", $p->codeJeux)[0] == 44) {
                        if (stristr($p->pari, "*") and strlen($p->pari) == 5) {
                            if (in_array($p->pari, $mariaj)) {
                                $gain = 'oui';
                                $paris[$i]->lot = "mariaj gratis";
                                $paris[$i]->montant = 1 * $prime;
                                $totalGain += 1 * $prime;
                                $paris[$i]->gain = $gain;
                            } else {
                                $paris[$i]->lot = "";
                                $paris[$i]->montant = 0;
                                $paris[$i]->gain = "non";
                            }
                        }
                    }

                }
                if ($gain == "oui") {
                    $listeVente[$index]->paris = json_encode($paris);
                    $listeVente[$index]->total_gain = $totalGain;
                    $listeVente[$index]->gain = $gain;
                    $listeVente[$index]->tire = "oui";
                } else {
                    $listeVente[$index]->paris = json_encode($paris);
                    $listeVente[$index]->total_gain = "0";
                    $listeVente[$index]->gain = "non";
                    $listeVente[$index]->tire = "oui";
                }
                $listeVente[$index]->update();
            }

        }
    }

    public function listeParPos($imei)
    {
        $con = self::connection();
        $req = "select *from vente where tid=:imei";
        $stmt = $con->prepare($req);
        $stmt->execute(array(":imei" => $imei));
        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function listerParVendeurDateTirage($id_vendeur, $date, $tirage)
    {
        $con = self::connection();
        $req = "select *from vente where date=:date and id_vendeur=:id_vendeur and tirage=:tirage and eliminer='non'";
        $stmt = $con->prepare($req);
        $stmt->execute(array(
            ":date" => $date,
            ":id_vendeur" => $id_vendeur,
            ":tirage" => $tirage
        ));

        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public function listerParVendeurDate($id_vendeur, $date)
    {
        $con = self::connection();
        $req = "select *from vente where date=:date and id_vendeur=:id_vendeur and eliminer='non'";
        $stmt = $con->prepare($req);
        $stmt->execute(array(
            ":date" => $date,
            ":id_vendeur" => $id_vendeur
        ));

        return $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
    }

    public static function listeParisParDate($date1, $date2, $tirage, $type_jeux = "")
    {
        $code = substr($type_jeux, 0, 2);
        $paris = array();
        $con = self::connection();
        if ($tirage == "tout") {
            $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' order by id desc";
        } else {
            $req = "select *from vente where date between '$date1' and '$date2' and tirage='{$tirage}' and eliminer='non' order by id desc";
        }
        $stmt = $con->prepare($req);
        $stmt->execute(array());
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        if (count($data) > 0) {
            foreach ($data as $v) {
                $p = $v->listeParis();
                if ($type_jeux !== "") {
                    foreach ($p as $i => $value) {
                        if (substr($value->codeJeux, 0, 2) !== $code) {
                            unset($p[$i]);
                        }
                    }
                }
                $paris = array_merge($paris, $p);
            }
        }

        return $paris;
    }

    public static function totalValide()
    {
        $con = self::connection();
        $req = "select *from vente where eliminer='non'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function totalEliminer()
    {
        $con = self::connection();
        $req = "select *from vente where eliminer='oui'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function total()
    {
        $con = self::connection();
        $req = "select *from vente";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function totalEncourElimination()
    {
        $con = self::connection();
        $req = "select *from vente_eliminer where status='en cours'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function totalGain()
    {
        $con = self::connection();
        $req = "select *from vente where gain='oui'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function totalPerdu()
    {
        $con = self::connection();
        $req = "select *from vente where gain<>'oui'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    private static function calculTotalMise($paris)
    {
        $montant = 0;
        foreach ($paris as $ii => $p) {
            $montant += $p->mise;
        }
        return $montant;
    }

    /*  public static function totalMontantVendu($date1,$date2,$id_vendeur=""){
        $paris=array();
        $con=self::connection();
        if($id_vendeur==""){
            $req="select *from vente where date between '$date1' and '$date2' and eliminer='non'";
        }else{
            $req="select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_vendeur='{$id_vendeur}'";
        }
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            foreach ($data as $v){
                $p=$v->listeParis();
                $paris=array_merge($paris,$p);
            }
        }
        return self::calculTotalMise($paris);
    }

    public static function totalPrimeApayer($date1,$date2,$id_vendeur="")
    {
        $con = self::connection();
        if ($id_vendeur == "") {
            $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui'";
        }else{
            $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui'";
        }
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetch();
        return $data['total'];
    }

    public static function commisionVendeur($id_vendeur,$date1,$date2){
        $posVendeur=PosVendeur::rechercherParVendeur($id_vendeur);
        $pourcentage=$posVendeur->pourcentage;
        $totalMontantVendu=self::totalMontantVendu($date1,$date2,$id_vendeur);
        $commision=($totalMontantVendu*$pourcentage)/100;
        return $commision;
    }

    public static function totalCommision($date1,$date2){
        $commision=0;
        $con=self::connection();
        $req="SELECT DISTINCT id_vendeur FROM vente where date between '$date1' and '$date2' and eliminer='non'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_OBJ);
        foreach ($data as $d){
            $commision+=self::commisionVendeur($d->id_vendeur,$date1,$date2);
        }
        return $commision;
    }*/

    public static function totalMontantVendu($date1, $date2, $id_vendeur = "", $succursal = "tout", $tirage = "tout")
    {
        $paris = array();
        $con = self::connection();
        if ($succursal == "tout" && $tirage == "tout") {
            if ($id_vendeur == "") {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and tire='oui'";
            } else {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_vendeur='{$id_vendeur}' and tire='oui'";
            }
        } elseif ($succursal == "tout" && $tirage !== "tout") {
            if ($id_vendeur == "") {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and tirage='{$tirage}' and tire='oui'";
            } else {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_vendeur='{$id_vendeur}' and tirage='{$tirage}' and tire='oui'";
            }
        } elseif ($succursal !== "tout" && $tirage == "tout") {
            if ($id_vendeur == "") {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_branche='{$succursal}' and tire='oui'";
            } else {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_vendeur='{$id_vendeur}'
                 and id_branche='{$succursal}' and tire='oui'";
            }
        } elseif ($succursal !== "tout" && $tirage !== "tout") {
            if ($id_vendeur == "") {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_branche='{$succursal}'
                and tirage='{$tirage}' and tire='oui'";
            } else {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_vendeur='{$id_vendeur}'
                 and id_branche='{$succursal}'
                 and tirage='{$tirage}' and tire='oui'";
            }
        }
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        if (count($data) > 0) {
            foreach ($data as $v) {
                $p = $v->listeParis();
                $paris = array_merge($paris, $p);
            }
        }
        return self::calculTotalMise($paris);
    }

    public static function totalPrimeApayer($date1, $date2, $id_vendeur = "", $succursal = "tout", $tirage = "tout")
    {
        $con = self::connection();
        if ($succursal == "tout" && $tirage == "tout") {
            if ($id_vendeur == "") {
                $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui'";
            } else {
                $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui' and id_vendeur='{$id_vendeur}'";
            }
        } elseif ($succursal == "tout" && $tirage !== "tout") {
            if ($id_vendeur == "") {
                $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui' and tirage='{$tirage}'";
            } else {
                $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui' and tirage='{$tirage}' and id_vendeur='{$id_vendeur}'";
            }
        } elseif ($succursal !== "tout" && $tirage == "tout") {
            if ($id_vendeur == "") {
                $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui' and id_branche='{$succursal}'";
            } else {
                $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui' and id_branche='{$succursal}' and id_vendeur='{$id_vendeur}'";
            }
        } elseif ($succursal !== "tout" && $tirage !== "tout") {
            if ($id_vendeur == "") {
                $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui' and tirage='{$tirage}' and id_branche='{$succursal}'";
            } else {
                $req = "select sum(total_gain) as total from vente where date between '$date1' and '$date2' and eliminer='non' and gain='oui'
        and tire='oui' and tirage='{$tirage}' and id_branche='{$succursal}' and id_vendeur='{$id_vendeur}'";
            }
        }

        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetch();
        return floatval($data['total']);
    }

    public static function commisionVendeur($id_vendeur, $date1, $date2, $succursal = "tout", $tirage = "tout")
    {
        $posVendeur = PosVendeur::rechercherParVendeur($id_vendeur);
        if ($posVendeur != null) {
            $totalMontantVendu = 0;
            $pourcentage = $posVendeur->pourcentage;
            if ($succursal == "tout" && $tirage == "tout") {
                $totalMontantVendu = self::totalMontantVendu($date1, $date2, $id_vendeur);
            } elseif ($succursal == "tout" && $tirage !== "tout") {
                $totalMontantVendu = self::totalMontantVendu($date1, $date2, $id_vendeur, "tout", $tirage);
            } elseif ($succursal !== "tout" && $tirage == "tout") {
                $totalMontantVendu = self::totalMontantVendu($date1, $date2, $id_vendeur, $succursal, "tout");
            } elseif ($succursal !== "tout" && $tirage !== "tout") {
                $totalMontantVendu = self::totalMontantVendu($date1, $date2, $id_vendeur, $succursal, $tirage);
            }
            $commision = ($totalMontantVendu * $pourcentage) / 100;
            return floatval($commision);
        } else {
            return floatval(0);
        }
    }

    public static function totalCommision($date1, $date2)
    {
        $commision = 0;
        $con = self::connection();
        $req = "SELECT DISTINCT id_vendeur FROM vente where date between '$date1' and '$date2' and eliminer='non' and tire='oui'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        foreach ($data as $d) {
            $commision += self::commisionVendeur($d->id_vendeur, $date1, $date2);
        }
        return $commision;
    }

    public static function totalFicheParis($date1, $date2, $id_vendeur, $succursal, $tirage)
    {
        $obj = new StdClass();
        $con = self::connection();
        if ($succursal == "tout" && $tirage == "tout") {
            if ($id_vendeur == "") {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and tire='oui'";
                $req1 = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and tire='oui' and gain='oui'";
            } else {
                $req = "select *from vente where date between '$date1' and '$date2' and id_vendeur='{$id_vendeur}' and eliminer='non' and tire='oui'";
                $req1 = "select *from vente where date between '$date1' and '$date2' and id_vendeur='{$id_vendeur}' and eliminer='non' and tire='oui' and gain='oui'";
            }
        } elseif ($succursal == "tout" && $tirage !== "tout") {
            if ($id_vendeur == "") {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and tirage='{$tirage}' and tire='oui'";
                $req1 = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and tirage='{$tirage}' and tire='oui' and gain='oui'";
            } else {
                $req = "select *from vente where date between '$date1' and '$date2' and id_vendeur='{$id_vendeur}' and eliminer='non' and tirage='{$tirage}' and tire='oui' ";
                $req1 = "select *from vente where date between '$date1' and '$date2' and id_vendeur='{$id_vendeur}' and eliminer='non' and tirage='{$tirage}' and tire='oui' and gain='oui' ";
            }
        } elseif ($succursal !== "tout" && $tirage == "tout") {
            if ($id_vendeur == "") {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_branche='{$succursal}' and tire='oui' ";
                $req1 = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_branche='{$succursal}' and tire='oui' and gain='oui'";
            } else {
                $req = "select *from vente where date between '$date1' and '$date2' and id_vendeur='{$id_vendeur}' and eliminer='non' and id_branche='{$succursal}' and tire='oui'";
                $req1 = "select *from vente where date between '$date1' and '$date2' and id_vendeur='{$id_vendeur}' and eliminer='non' and id_branche='{$succursal}' and tire='oui' and gain='oui'";
            }
        } elseif ($succursal !== "tout" && $tirage !== "tout") {
            if ($id_vendeur == "") {
                $req = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_branche='{$succursal}' and tirage='{$tirage}' and tire='oui'";
                $req1 = "select *from vente where date between '$date1' and '$date2' and eliminer='non' and id_branche='{$succursal}' and tirage='{$tirage}' and tire='oui' and gain='oui'";
            } else {
                $req = "select *from vente where date between '$date1' and '$date2' and id_vendeur='{$id_vendeur}' and eliminer='non' and id_branche='{$succursal}' and tirage='{$tirage}' and tire='oui'";
                $req1 = "select *from vente where date between '$date1' and '$date2' and id_vendeur='{$id_vendeur}' and eliminer='non' and id_branche='{$succursal}' and tirage='{$tirage}' and tire='oui' and gain='oui'";
            }
        }

        $stmt = $con->prepare($req);
        $stmt->execute();
        $obj->totalFiche = $stmt->rowCount();
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        $paris = array();
        if (count($data) > 0) {
            foreach ($data as $v) {
                $p = $v->listeParis();
                $paris = array_merge($paris, $p);
            }
        }
        $obj->totalParis = count($paris);

        $stmt1 = $con->prepare($req1);
        $stmt1->execute();
        $obj->totalFicheGagnant = $stmt1->rowCount();

        return $obj;
    }

    public static function getRapportVendeur($id_vendeur, $tirage, $date1, $date2)
    {
        $pos = new Pos();
        $pos = $pos->rechercherParVendeur($id_vendeur);

        $vendeur = new Vendeur();
        $vendeur = $vendeur->findById($id_vendeur);
        $id_branche = $vendeur->id_branche;
        $branche = new Branche();
        $branche = $branche->findById($id_branche);

        $obj = new StdClass();
        $totalVendu = 0;
        $totalPrim = 0;
        $totalCommision = 0;
        $trest = 0;
        $tFicheParis = self::totalFicheParis($date1, $date2, $id_vendeur, $id_branche, $tirage);

        $tVendu = self::totalMontantVendu($date1, $date2, $id_vendeur, $id_branche, $tirage);
        if ($tVendu == null) {
            $tVendu = 0;
        }
        $totalVendu += $tVendu;
        $tPrim = self::totalPrimeApayer($date1, $date2, $id_vendeur, $id_branche, $tirage);
        if ($tPrim == null) {
            $tPrim = 0;
        }
        $totalPrim += $tPrim;

        $tCommision = self::commisionVendeur($id_vendeur, $date1, $date2, $id_branche, $tirage);
        $totalCommision += $tCommision;

        $rest = $tVendu - ($tPrim + $tCommision);
        $trest += $rest;

        $lotG = new LotGagnant();
        $lotG = $lotG->rechercherParDateTirage($date1, $tirage);

        $obj->tirage = $tirage;
        $obj->date1 = $date1;
        $obj->date2 = $date2;
        $obj->pos = $pos->imei;
        $obj->totalFiche = $tFicheParis->totalFiche;
        $obj->totalFicheGagnant = $tFicheParis->totalFicheGagnant;
        $obj->totalParis = $tFicheParis->totalParis;

        $obj->totalVendu = DefaultApp::formatComptable($totalVendu);
        $obj->totalPrim = DefaultApp::formatComptable($totalPrim);
        $obj->totalCommission = $totalCommision;
        $obj->rest = DefaultApp::formatComptable($trest);
        $obj->date_generer = date("Y-m-d H:i:s");
        $obj->succursal = $branche;
        $obj->vendeur = $vendeur;
        if ($lotG != null) {
            $obj->lot = $lotG->loto3 . " " . $lotG->lot2 . " " . $lotG->lot3;
        } else {
            $obj->lot = "n/a";
        }
        return $obj;

    }


    public static function getRapport($date1, $date2, $tirage = "tout", $succursal = "tout")
    {
        //succursal egale branche
        $v = new Vendeur();
        $listeVendeur = $v->findAll();
        $liste = [];
        $obj = new StdClass();
        $totalVendu = 0;
        $totalPrim = 0;
        $totalCommision = 0;
        $totalFiche = 0;
        $totalFicheGagnant = 0;
        $totalParis = 0;
        $trest = 0;

        foreach ($listeVendeur as $vendeur) {
            $id_vendeur = $vendeur->id;
            $tFicheParis = self::totalFicheParis($date1, $date2, $id_vendeur, $succursal, $tirage);
            if ($tFicheParis->totalFiche > 0) {
                $v = new Vendeur();
                $v = $v->findById($id_vendeur);
                $o = new StdClass();
                $tVendu = self::totalMontantVendu($date1, $date2, $id_vendeur, $succursal, $tirage);
                if ($tVendu == null) {
                    $tVendu = 0;
                }
                $totalVendu += $tVendu;
                $tPrim = self::totalPrimeApayer($date1, $date2, $id_vendeur, $succursal, $tirage);
                if ($tPrim == null) {
                    $tPrim = 0;
                }
                $totalPrim += $tPrim;

                $tCommision = self::commisionVendeur($id_vendeur, $date1, $date2, $succursal, $tirage);
                $totalCommision += $tCommision;


                $rest = $tVendu - ($tPrim + $tCommision);
                $trest += $rest;


                $o->totalVendu = DefaultApp::formatComptable($tVendu);
                $o->totalPrim = DefaultApp::formatComptable($tPrim);
                $o->totalCommission = DefaultApp::formatComptable($tCommision);
                $o->rest = DefaultApp::formatComptable($rest);

                $o->totalFiche = $tFicheParis->totalFiche;
                $o->totalFicheGagnant = $tFicheParis->totalFicheGagnant;
                $o->totalParis = $tFicheParis->totalParis;

                $totalFiche += $tFicheParis->totalFiche;
                $totalFicheGagnant += $tFicheParis->totalFicheGagnant;
                $totalParis += $tFicheParis->totalParis;

                $o->agent = ucfirst($v->nom . " " . $v->prenom);
                $liste[] = $o;
            }
        }

        $obj->totalVendu = DefaultApp::formatComptable($totalVendu);
        $obj->totalPrim = DefaultApp::formatComptable($totalPrim);
        $obj->totalCommission = DefaultApp::formatComptable($totalCommision);
        $obj->rest = DefaultApp::formatComptable($trest);
        $obj->totalFiche = $totalFiche;
        $obj->totalFicheGagnant = $totalFicheGagnant;
        $obj->totalParis = $totalParis;
        $obj->liste = $liste;
        return $obj;
    }

    public static function listeDemmandeElimination2()
    {
        $resultat = array();
        $con = self::connection();
        $req = "select *from vente_eliminer where status='en cours'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        foreach ($data as $vee) {
            $v = new Vente();
            $v = $v->findById($vee->id_vente);
            if ($v->tire !== 'oui') {
                $resultat[] = $v;
            }
        }

        foreach ($resultat as $i => $v) {
            $ve = new Vendeur();
            $ve = $ve->findById($v->id_vendeur);
            $resultat[$i]->vendeur = $ve;

            $paris = json_decode($v->paris);
            //parcourir list des paris pour voir les gagnant
            $montant = 0;
            foreach ($paris as $ii => $p) {
                $montant += floatval($p->mise);
            }
            $resultat[$i]->montant = $montant;
        }

        return $resultat;
    }

}
