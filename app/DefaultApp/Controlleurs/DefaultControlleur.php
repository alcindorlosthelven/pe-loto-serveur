<?php
/**
 * Created by PhpStorm.
 * User: ALCINDOR LOSTHELVEN
 * Date: 29/03/2018
 * Time: 22:30
 */

namespace app\DefaultApp\Controlleurs;
use app\DefaultApp\Models\Client;
use app\DefaultApp\Models\TestModel;
use app\DefaultApp\Models\Utilisateur;
use app\DefaultApp\Models\Vendeur;
use systeme\Controlleur\Controlleur;
class DefaultControlleur extends Controlleur
{
    public function index(){
        $variable['titre']="Acceuil";
        return $this->render("default/index",$variable);
    }

    public function login(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"));

        if(empty($data->user_name)){
            http_response_code(503);
            echo json_encode(array("message" => "id invalide"));
            return;
        }

        if(empty($data->password)){
            http_response_code(503);
            echo json_encode(array("message" => "id invalide"));
            return;
        }

        $msg=Client::login($data->user_name,$data->password);
        if($msg=="no"){
            $msg_1=Vendeur::login($data->user_name,$data->password);
            if($msg_1=="no"){
               $msg_2=Utilisateur::login($data->user_name,$data->password);
                if($msg_2=="no"){
                    http_response_code(404);
                    echo json_encode(array("message"=>"mot de passe ou pseudo incorrect"));
                }else{
                    http_response_code(200);
                    echo json_encode($msg_2);
                }
            }else{
                http_response_code(200);
                echo json_encode($msg_1);
            }
        }else{
            http_response_code(200);
            echo json_encode($msg);
        }

    }

    public function logout(){

    }
 
}
