<?php


namespace app\DefaultApp\Controlleurs;

use app\DefaultApp\Models\Client;
use app\DefaultApp\Models\LotGagnant;
use app\DefaultApp\Models\Tirage;
use app\DefaultApp\Models\Vendeur;
use app\DefaultApp\Models\Vente;
use app\DefaultApp\Models\VenteEliminer;
use systeme\Controlleur\Controlleur;

class LotGagnantControlleur extends Controlleur
{
    public function add()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        $data = json_decode(file_get_contents("php://input"));
        $con=\app\DefaultApp\DefaultApp::connection();
        $con->beginTransaction();
        try{
            set_time_limit(10000);
            $v = new \app\DefaultApp\Models\LotGagnant();
            $v->date=$data->date;
            $v->tirage=$data->tirage;
            $v->lot1=$data->lot1;
            $v->lot2=$data->lot2;
            $v->lot3=$data->lot3;
            $v->loto3=$data->loto3;
            $date = date("Y-m-d");

            if(count(Vente::listeDemmandeElimination2())>0){
                http_response_code(503);
                echo json_encode(array("message"=>count(Vente::listeDemmandeElimination2())." fiches encours d'élimination"));
                return ;
            }

            if ($data->date > $date) {
                http_response_code(503);
                echo json_encode(array("message"=>"Date incorrect, la date doit etre aujourd'hui ou hier"));
                return;
            }

            /*if ($data->date == $date) {
                http_response_code(503);
                if (Tirage::isTirageEncour($data->tirage)) {
                    echo json_encode(array("message"=>"Imposible d'ajouter le lot gagnant, le tirage choisie est en cours"));
                    return;
                }
                $heure = date("H:i");
                $ti = Tirage::rechercherParNom($data->tirage);
                if ($heure < $ti->heure_fermeture) {
                    echo json_encode(array("message"=>"Imposible d'ajouter le lot gagnant heure inccorect"));
                    return;
                }
            }*/


            $lot1 = intval($data->lot1);
            $lot2 = intval($data->lot2);
            $lot3 = intval($data->lot3);
            $loto3 = intval($data->loto3);

            if ($lot1 > 99 || $lot1 < 0) {
                http_response_code(503);
                echo json_encode(array("message"=>"1er lot incorrect"));
                return;
            }
            if (strlen($lot1) == 1) {
                $lot1 = "0" . $lot1;
            }

            if ($lot2 > 99 || $lot2 < 0) {
                http_response_code(503);
                echo json_encode(array("message"=>"2em lot incorrect"));
                return;
            }
            if (strlen($lot2) == 1) {
                $lot2 = "0" . $lot2;
            }

            if ($lot3 > 99 || $lot3 < 0) {
                http_response_code(503);
                echo json_encode(array("message"=>"3em lot incorrect"));
                return;
            }
            if (strlen($lot3) == 1) {
                $lot3 = "0" . $lot3;
            }

            if ($loto3 > 9 || $loto3 < 0) {
                echo json_encode(array("message"=>"lotto 3 incorrect"));
                return;
            }

            $v->lot1 = $lot1;
            $v->lot2 = $lot2;
            $v->lot3 = $lot3;
            $v->loto3 = $loto3;

            $borlette = array(
                "lot1" => $lot1,
                "lot2" => $lot2,
                "lot3" => $lot3
            );

            $loto4 = array(
                "option1" => $lot2 . "" . $lot3,
                "option1_inverse" => $lot3 . "" . $lot2,

                "option2" => $lot1 . "" . $lot2,
                "option2_inverse" => $lot2 . "" . $lot1,

                "option3" => $lot1 . "" . $lot3,
                "option3_inverse" => $lot3 . "" . $lot1,
            );

            $loto5 = array(
                "option1" => $loto3 . $lot1 . "" . $lot2,
                "option2" => $loto3 . $lot1 . "" . $lot3,
                "option3" => substr($lot1, 1, 1) . "" . $lot2 . "" . $lot3
            );

            $mariaj = array(
                $lot1 . "*" . $lot2,
                $lot2 . "*" . $lot1,

                $lot1 . "*" . $lot3,
                $lot3 . "*" . $lot1,

                $lot2 . "*" . $lot3,
                $lot3 . "*" . $lot2,
            );

            $v->borlette = json_encode($borlette);
            $v->loto4 = json_encode($loto4);
            $v->loto5 = json_encode($loto5);
            $v->mariaj = json_encode($mariaj);
            $v->loto3 = $v->loto3 . "" . $v->lot1;
            $m = $v->add();
            if ($m == "ok") {
                http_response_code(200);
                Vente::updateBilletForLotGagnant($data->date, $data->tirage);
                $t = new \app\DefaultApp\Models\Tracabilite();
                $t->action = "ajouter lot gagnant pour tirage : ".$data->tirage."<br>" . $v->borlette . '<br>loto 3 :' . $v->loto3;
                $t->add();
                Vente::updateBalanceClient($date,$v->tirage);
                echo json_encode(array("message"=>$m));
                $con->commit();
            } else {
                http_response_code(503);
                $con->rollBack();
                echo json_encode(array("message"=>$m));
            }
        }catch (\Exception $ex){
            http_response_code(503);
            $con->rollBack();
            echo json_encode(array("message"=>$ex->getMessage()));
        }
    }

    public function update()
    {
        try {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));
            $date = date("Y-m-d");
            http_response_code(503);
            if (empty($data->id)) {
                http_response_code(503);
                echo json_encode(array("message" => "Id invalide"));
                return;
            }

            if (empty($data->tirage)) {
                http_response_code(503);
                echo json_encode(array("message" => "Tirage invalide"));
                return;
            }

            if (empty($data->lot1)) {
                http_response_code(503);
                echo json_encode(array("message" => "Lot1 invalide"));
                return;
            }

            if (strlen($data->lot1) == 1) {
                $data->lot1 = "0" . $data->lot1;
            }

            if (empty($data->lot2)) {
                http_response_code(503);
                echo json_encode(array("message" => "Lot2 invalide"));
                return;
            }

            if (strlen($data->lot2) == 1) {
                $data->lot2 = "0" . $data->lot2;
            }

            if (empty($data->lot3)) {
                http_response_code(503);
                echo json_encode(array("message" => "Lot3 invalide"));
                return;
            }
            if (strlen($data->lot3) == 1) {
                $data->lot3 = "0" . $data->lot3;
            }

            if (empty($data->loto3)) {
                http_response_code(503);
                echo json_encode(array("message" => "Loto3 invalide"));
                return;
            }

            set_time_limit(10000);
            $v = new \app\DefaultApp\Models\LotGagnant();
            $date = date("Y-m-d");

            if (count(Vente::listeDemmandeElimination2()) > 0) {
                echo json_encode(array("message" => count(Vente::listeDemmandeElimination2()) . " fiches encours d'élimination, verifié avant de continuer"));
                return;
            }

            if ($data->date > $date) {
                echo json_encode(array("message" => "Date incorrect, la date doit etre aujourd'hui ou hier"));
                return;
            }

            if ($data->date == $date) {
                if (Tirage::isTirageEncour($data->tirage)) {
                    echo json_encode(array("message" => "Imposible d'ajouter le lot gagnant, le tirage choisie est en cours"));
                    return;
                }
                $heure = date("H:i");
                $ti = Tirage::rechercherParNom($data->tirage);
                if ($heure < $ti->heure_fermeture) {
                    echo json_encode(array("message" => "Imposible d'ajouter le lot gagnant heure inccorect"));
                    return;
                }
            }

            $lot1 = $data->lot1;
            $lot2 = $data->lot2;
            $lot3 = $data->lot3;
            $loto3 = $data->loto3;

            $v->lot1 = $lot1;
            $v->lot2 = $lot2;
            $v->lot3 = $lot3;
            $v->loto3 = $loto3;
            $v->date = $data->date;
            $v->tirage = $data->tirage;
            $v->id = $data->id;

            $borlette = array(
                "lot1" => $lot1,
                "lot2" => $lot2,
                "lot3" => $lot3
            );

            $loto4 = array(
                "option1" => $lot2 . "" . $lot3,
                "option1_inverse" => $lot3 . "" . $lot2,

                "option2" => $lot1 . "" . $lot2,
                "option2_inverse" => $lot2 . "" . $lot1,

                "option3" => $lot1 . "" . $lot3,
                "option3_inverse" => $lot3 . "" . $lot1,
            );

            $loto5 = array(
                "option1" => $loto3 . $lot1 . "" . $lot2,
                "option2" => $loto3 . $lot1 . "" . $lot3,
                "option3" => substr($lot1, 1, 1) . "" . $lot2 . "" . $lot3
            );

            $mariaj = array(
                $lot1 . "*" . $lot2,
                $lot2 . "*" . $lot1,

                $lot1 . "*" . $lot3,
                $lot3 . "*" . $lot1,

                $lot2 . "*" . $lot3,
                $lot3 . "*" . $lot2,
            );

            $v->borlette = json_encode($borlette);
            $v->loto4 = json_encode($loto4);
            $v->loto5 = json_encode($loto5);
            $v->mariaj = json_encode($mariaj);
            $v->loto3 = $v->loto3 . "" . $v->lot1;
            $m = $v->update();
            if ($m == "ok") {
                Vente::updateBilletForLotGagnantModifier($data->date, $data->tirage);
                $t = new \app\DefaultApp\Models\Tracabilite();
                $t->action = "modifier lot gagnant" . $v->borlette . '<br>loto 3 :' . $v->loto3;
                $t->add();
                $v = $v->lastObjet();
                $v = $v->toJson();
                http_response_code(200);
                echo $v;
                return;
            }
            http_response_code(503);
            echo json_encode(array("message" => $m));

        } catch (\Exception $ex) {
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function get($id)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        if (empty($id)) {
            http_response_code(503);
            echo json_encode(array("message" => "id invalide"));
            return;
        }

        $obj = new LotGagnant();
        $obj = $obj->findById($id);

        if ($obj == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }
        http_response_code(200);
        $obj = json_encode($obj);
        echo $obj;
    }

    public function gets()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        $obj = new LotGagnant();
        $liste = $obj->findAll();
        http_response_code(200);
        $obj = json_encode($liste);
        echo $obj;
    }

    public function delete($id)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: DELETE");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        if (empty($id)) {
            http_response_code(503);
            echo json_encode(array("message" => "id invalide"));
            return;
        }

        $obj = new LotGagnant();
        $obj = $obj->findById($id);

        if ($obj == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }

        $m = $obj->deleteById($id);
        if ($m) {
            http_response_code(200);
            echo json_encode(array("message" => "supprimer avec success"));
            return;
        }

        http_response_code(503);
        echo json_encode(array("message" => $m));

    }

    public function getParDateTirage()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        if (isset($_GET['date']) and isset($_GET['tirage'])) {
            $obj = new LotGagnant();
            $obj = $obj->rechercherParDateTirage($_GET['date'], $_GET['date2'], $_GET['tirage']);
            http_response_code(200);
            $obj = json_encode($obj);
            echo $obj;
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Date ou Tirage ou lotterie  incorrect"));
            return;
        }
    }

    public function getBilletGagnant()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        if (isset($_GET['date']) and isset($_GET['tirage'])) {
            if (isset($_GET['id_vendeur'])) {
                $listeVenteGagnant = Vente::getBilletGagnant($_GET['date'], $_GET['tirage'], $_GET['id_vendeur']);
            } else {
                $listeVenteGagnant = Vente::getBilletGagnant($_GET['date'], $_GET['tirage']);
            }

            foreach ($listeVenteGagnant as $index => $value) {
                $id_vendeur = $value->id_vendeur;
                $id_client = $value->id_client;
                $client = new Client();
                $client = $client->findById($id_client);
                $vendeur = new Vendeur();
                $vendeur = $vendeur->findById($id_vendeur);

                $listeVenteGagnant[$index]->vendeur = $vendeur;
                $listeVenteGagnant[$index]->client = $client;

                $ve = VenteEliminer::rechercheParIdVente($listeVenteGagnant[$index]->id);
                if ($ve !== null) {
                    $listeVenteGagnant[$index]->venteEliminer = $ve;
                }

                $paris = json_decode($value->paris);
                //parcourir list des paris pour voir les gagnant
                $montant = 0;
                foreach ($paris as $i => $p) {
                    $montant += $p->mise;
                }
                $listeVenteGagnant[$index]->montant = $montant;
            }

            http_response_code(200);
            echo json_encode($listeVenteGagnant);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Date ou Tirage incorrect"));
            return;
        }
    }

    public function getBilletGagnantPayer()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        if (isset($_GET['date']) and isset($_GET['tirage'])) {
            if (isset($_GET['id_vendeur'])) {
                $listeVenteGagnant = Vente::getBilletGagnantPayer($_GET['date'], $_GET['tirage'], $_GET['id_vendeur']);
            } else {
                $listeVenteGagnant = Vente::getBilletGagnantPayer($_GET['date'], $_GET['tirage']);
            }
            foreach ($listeVenteGagnant as $index => $value) {
                $id_vendeur = $value->id_vendeur;
                $id_client = $value->id_client;
                $client = new Client();
                $client = $client->findById($id_client);
                $vendeur = new Vendeur();
                $vendeur = $vendeur->findById($id_vendeur);

                $listeVenteGagnant[$index]->vendeur = $vendeur;
                $listeVenteGagnant[$index]->client = $client;

                $ve = VenteEliminer::rechercheParIdVente($listeVenteGagnant[$index]->id);
                if ($ve !== null) {
                    $listeVenteGagnant[$index]->venteEliminer = $ve;
                }

                $paris = json_decode($value->paris);
                //parcourir list des paris pour voir les gagnant
                $montant = 0;
                foreach ($paris as $i => $p) {
                    $montant += $p->mise;
                }
                $listeVenteGagnant[$index]->montant = $montant;
            }

            http_response_code(200);
            echo json_encode($listeVenteGagnant);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Date ou Tirage incorrect"));
            return;
        }
    }

    public function getBilletGagnantTout()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        if (isset($_GET['date']) and isset($_GET['tirage'])) {
            if (isset($_GET['id_vendeur'])) {
                $listeVenteGagnant = Vente::getBilletGagnantTout($_GET['date'], $_GET['tirage'], $_GET['id_vendeur']);
            } else {
                $listeVenteGagnant = Vente::getBilletGagnantTout($_GET['date'], $_GET['tirage']);
            }
            foreach ($listeVenteGagnant as $index => $value) {
                $id_vendeur = $value->id_vendeur;
                $id_client = $value->id_client;
                $client = new Client();
                $client = $client->findById($id_client);
                $vendeur = new Vendeur();
                $vendeur = $vendeur->findById($id_vendeur);

                $listeVenteGagnant[$index]->vendeur = $vendeur;
                $listeVenteGagnant[$index]->client = $client;

                $ve = VenteEliminer::rechercheParIdVente($listeVenteGagnant[$index]->id);
                if ($ve !== null) {
                    $listeVenteGagnant[$index]->venteEliminer = $ve;
                }

                $paris = json_decode($value->paris);
                //parcourir list des paris pour voir les gagnant
                $montant = 0;
                foreach ($paris as $i => $p) {
                    $montant += $p->mise;
                }
                $listeVenteGagnant[$index]->montant = $montant;
            }

            http_response_code(200);
            echo json_encode($listeVenteGagnant);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Date ou Tirage incorrect"));
            return;
        }
    }

    public function getLotGagnantFromMagayoMidi()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        $lg = LotGagnant::getLotGagnantFromMagayoMidi();
        if ($lg == null) {
            http_response_code(404);
            echo json_encode(array("message" => "non disponible"));
            return;
        }

        http_response_code(200);
        echo json_encode($lg);
    }

}
