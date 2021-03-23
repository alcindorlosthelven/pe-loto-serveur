<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\Utilisateur;
use systeme\Controlleur\Controlleur;

class UtilisateurControlleur extends Controlleur
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
                echo json_encode(array("message" => "prenom invalide"));
                return;
            }

            if(empty($data->pseudo)){
                http_response_code(503);
                echo json_encode(array("message" => "pseudo invalide"));
                return;
            }

            if(empty($data->password)){
                http_response_code(503);
                echo json_encode(array("message" => "password invalide"));
                return;
            }

            if(empty($data->role)){
                http_response_code(503);
                echo json_encode(array("message" => "role invalide"));
                return;
            }

            $obj=new Utilisateur();
            $obj->remplire((array)$data);
            $obj->setPassword(md5($data->password));
            $m=$obj->add();
            if($m=="ok"){
                $obj=$obj->lastObjet();
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
            echo json_encode(array("message" => "prenom invalide"));
            return;
        }

        if(empty($data->pseudo)){
            http_response_code(503);
            echo json_encode(array("message" => "pseudo invalide"));
            return;
        }

        if(empty($data->password)){
            http_response_code(503);
            echo json_encode(array("message" => "password invalide"));
            return;
        }

        if(empty($data->role)){
            http_response_code(503);
            echo json_encode(array("message" => "role invalide"));
            return;
        }


        $obj=new Utilisateur();
        $obj = $obj->findById($data->id);
        if ($obj == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}"));
            return;
        }

        $obj->remplire((array)$data);
        $obj->setPassword(md5($data->password));

        $m=$obj->update();
        if($m==="ok"){
            $obj=json_encode($obj);
            http_response_code(200);
            echo $obj;
            return;
        }

        http_response_code(503);
        echo json_encode(array("message" => $m));
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

        $obj=new Utilisateur();
        $obj=$obj->findById($id);

        if ($obj == null) {
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

        $obj=new Utilisateur();
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

        $obj=new Utilisateur();
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

    public function total(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $v=new Utilisateur();
        $obj=$v->total();
        http_response_code(200);
        $obj = json_encode($obj);
        echo $obj;
    }

}
