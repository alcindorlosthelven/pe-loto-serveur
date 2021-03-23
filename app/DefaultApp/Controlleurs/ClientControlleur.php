<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\Client;
use systeme\Controlleur\Controlleur;

class ClientControlleur extends Controlleur
{

    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->nom)){
                http_response_code(503);
                echo json_encode(array("message" => "nom invalide"));
                return;
            }

            if(empty($data->prenom)){
                http_response_code(503);
                echo json_encode(array("message" => "prénom invalide"));
                return;
            }

            if(empty($data->sexe)){
                http_response_code(503);
                echo json_encode(array("message" => "sexe invalide"));
                return;
            }

            if(empty($data->telephone)){
                http_response_code(503);
                echo json_encode(array("message" => "telephone invalide"));
                return;
            }

            $pseudo="c-".substr($data->nom,0,1).$data->prenom;
            $password=md5($data->telephone);
            $connect = "non";


            $obj=new Client();
            $obj->remplire((array)$data);
            $obj->setPseudo($pseudo);
            $obj->setPassword($password);
            $obj->setConnect($connect);

            $m=$obj->add();
            if($m=="ok"){
                $obj=$obj->lastObjet();
                $obj->message="enregistrer avec success";
                $obj=$obj->toJson();
                http_response_code(200);
                echo $obj;
                return;
            }
            http_response_code(503);
            echo json_encode(array("message" => $m));
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function update(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: PUT");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->id)){
                http_response_code(503);
                echo json_encode(array("message" => "id invalide"));
                return;
            }

            if(empty($data->nom)){
                http_response_code(503);
                echo json_encode(array("message" => "nom invalide"));
                return;
            }

            if(empty($data->prenom)){
                http_response_code(503);
                echo json_encode(array("message" => "prénom invalide"));
                return;
            }

            if(empty($data->sexe)){
                http_response_code(503);
                echo json_encode(array("message" => "sexe invalide"));
                return;
            }

            if(empty($data->telephone)){
                http_response_code(503);
                echo json_encode(array("message" => "telephone invalide"));
                return;
            }

            $obj=new Client();
            $obj = $obj->findById($data->id);
            if ($obj == null) {
                http_response_code(404);
                echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}","status"=>503));
                return;
            }

            $obj->remplire((array)$data);
            $m=$obj->update();
            if($m==="ok"){
                $obj->message="modifer avec success";
                $obj=json_encode($obj);
                http_response_code(200);
                echo $obj;
                return;
            }

            http_response_code(503);
            echo json_encode(array("message" => $m));
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function get($id){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        if(empty($id)){
            http_response_code(503);
            echo json_encode(array("message" => "id invalide"));
            return;
        }

        $obj=new Client();
        $obj=$obj->findById($id);

        if ($obj== null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }
        http_response_code(200);
        $obj=json_encode($obj);
        echo $obj;
    }

    public function gets(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        $obj=new Client();
        $liste=$obj->findAll();
        http_response_code(200);
        $obj=json_encode($liste);
        echo $obj;
    }

    public function delete($id){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: DELETE");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        if(empty($id)){
            http_response_code(503);
            echo json_encode(array("message" => "id invalide"));
            return;
        }

        $obj=new Client();
        $obj=$obj->findById($id);

        if ($obj == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }

        $m=$obj->deleteById($id);
        if($m){
            http_response_code(200);
            echo json_encode(array("message"=>"supprimer avec success"));
            return;
        }

        http_response_code(503);
        echo json_encode(array("message" => $m));

    }

    public function getDefaultClient(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        $obj=new Client();
        $obj=$obj->getDefaultClient();
        if ($obj== null) {
            http_response_code(404);
            echo json_encode(array("message" => "Client par defaut non trouver dans la base de donnee"));
            return;
        }
        http_response_code(200);
        $obj=json_encode($obj);
        echo $obj;
    }

    public function total(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $v=new Client();
        $obj=$v->total();
        http_response_code(200);
        $obj = json_encode($obj);
        echo $obj;
    }

}
