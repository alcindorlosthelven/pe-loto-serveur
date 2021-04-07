<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\Tirage;
use Cassandra\Time;
use systeme\Controlleur\Controlleur;

class TirageControlleur extends Controlleur
{
    public function add()
    {
        try {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if (empty($data->tirage)) {
                http_response_code(503);
                echo json_encode(array("message" => "tirage invalide"));
                return;
            }

            if (empty($data->nom)) {
                http_response_code(503);
                echo json_encode(array("message" => "nom invalide"));
                return;
            }

            if (empty($data->heure_fermeture)) {
                http_response_code(503);
                echo json_encode(array("message" => "heure fermeture invalide"));
                return;
            }

            if (empty($data->heure_ouverture)) {
                http_response_code(503);
                echo json_encode(array("message" => "heure ouverture invalide"));
                return;
            }

            if (empty($data->heure_rapport)) {
                http_response_code(503);
                echo json_encode(array("message" => "heure rapport invalide"));
                return;
            }

            if (empty($data->email_rapport)) {
                http_response_code(503);
                echo json_encode(array("message" => "email rapport invalide"));
                return;
            }


            $obj = new Tirage();
            $obj->remplire((array)$data);
            $obj->setStatut("n/a");
            $m = $obj->add();
            if ($m == "ok") {
                $obj = $obj->lastObjet();
                $obj = $obj->toJson();
                http_response_code(200);
                echo $obj;
                return;
            }
            http_response_code(503);
            echo json_encode(array("message" => $m));
        } catch (\Exception $ex) {
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function update()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: PUT");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id)) {
            http_response_code(503);
            echo json_encode(array("message" => "id invalide"));
            return;
        }

        if (empty($data->tirage)) {
            http_response_code(503);
            echo json_encode(array("message" => "tirage invalide"));
            return;
        }

        if (empty($data->statut)) {
            http_response_code(503);
            echo json_encode(array("message" => "statut invalide"));
            return;
        }

        $obj = new Tirage();
        $obj = $obj->findById($data->id);

        if ($obj == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}"));
            return;
        }

        $obj->remplire((array)$data);
        $m = $obj->update();
        if ($m === "ok") {
            $obj = json_encode($obj);
            http_response_code(200);
            echo $obj;
            return;
        }

        http_response_code(503);
        echo json_encode(array("message" => $m));
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

        $obj = new Tirage();
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


        $obj = new Tirage();
        if (isset($_GET['encours'])) {
            http_response_code(200);
            $liste = $obj->listeEncours();
            echo json_encode($liste);
        } else {
            $liste = $obj->findAll();
            http_response_code(200);
            $obj = json_encode($liste);
            echo $obj;
        }

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

        $obj = new Tirage();
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


    public function fermer()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: DELETE");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        date_default_timezone_set("America/Port-au-Prince");
        $heureActuel = date('H:i');
        $t=new Tirage();
        $liste=$t->findAll();
        foreach($liste as $ti){
            $h_ouverture=$ti->heure_ouverture;
            $h_fermeture=$ti->heure_fermeture;

            if($ti->statut=="en cours"){
                if($heureActuel>=$h_fermeture){
                    $ti->statut="n/a";
                    $ti->update();
                    echo json_encode(array("message"=>"tirage {$ti->tirage} fermer avec success"));
                }
            }

            if($ti->statut=="n/a"){
                if($heureActuel>=$h_ouverture && $heureActuel<$h_fermeture){
                    $ti->statut="en cours";
                    $ti->update();
                    echo json_encode(array("message"=>"tirage {$ti->tirage} ouvrir avec success"));
                }
            }

        }

        echo json_encode(array("message"=>"aucun tirage a ouvrir ou fermer"));
    }
}
