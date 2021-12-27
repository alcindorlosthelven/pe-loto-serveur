<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 29/03/2018
 * Time: 22:30
 */

namespace app\DefaultApp\Controlleurs;

use app\DefaultApp\Models\App;
use app\DefaultApp\Models\Client;
use app\DefaultApp\Models\Pos;
use app\DefaultApp\Models\TestModel;
use app\DefaultApp\Models\Utilisateur;
use app\DefaultApp\Models\Vendeur;
use app\DefaultApp\Models\Vente;
use stdClass;
use systeme\Controlleur\Controlleur;

class DefaultControlleur extends Controlleur
{
    public function index()
    {
        $variable['titre'] = "Acceuil";
        return $this->render("default/index", $variable);
    }

    public function login()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->user_name)) {
            http_response_code(503);
            echo json_encode(array("message" => "id invalide"));
            return;
        }

        if (empty($data->password)) {
            http_response_code(503);
            echo json_encode(array("message" => "id invalide"));
            return;
        }

        $msg = Client::login($data->user_name, $data->password);
        if ($msg['statut'] == "no") {
            $msg_1 = Vendeur::login($data->user_name, $data->password);
            if ($msg_1['statut'] == "no") {
                $msg_2 = Utilisateur::login($data->user_name, $data->password);
                if ($msg_2 == "no") {
                    http_response_code(404);
                    echo json_encode(array("message" => "mot de passe ou pseudo incorrect"));
                } else {
                    http_response_code(200);
                    echo json_encode($msg_2);
                }
            } else {
                http_response_code(200);
                echo json_encode($msg_1['result']);
            }
        } else {
            http_response_code(200);
            echo json_encode($msg['result']);
        }

    }

    public function logout()
    {

    }


    public function token()
    {
        $OKTAISSUER = "https://dev-50587677.okta.com/oauth2/default";
        $OKTACLIENTID = "fdgdfjkjsjkjfdssfdf";
        $OKTASECRET = "ruthamar1991";
        App::obtainToken($OKTAISSUER,$OKTACLIENTID,$OKTASECRET,"");
    }

    public function infosDashboard()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $obj=new StdClass();
        $obj->posActif=Pos::totalActif();
        $obj->posInactif=Pos::totalInactif();
        $obj->pos=Pos::total();
        $obj->fiche=Vente::total();
        $obj->ficheValide=Vente::totalValide();
        $obj->ficheEliminer=Vente::totalEliminer();
        $obj->ficheEncourElimination=Vente::totalEncourElimination();
        $obj->ficheGagnant=Vente::totalGain();
        $obj->fichePerdant=Vente::totalPerdu();
        $obj->clients=Client::total();
        $obj->vendeurs=Vendeur::total();
        $obj->utilisateurs=Utilisateur::total();
        $obj->listeFicheEncourElimination=Vente::listeDemmandeElimination();

        http_response_code(200);
        $obj = json_encode($obj);
        echo $obj;
    }
}
