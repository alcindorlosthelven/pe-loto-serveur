<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\Pos;
use systeme\Controlleur\Controlleur;

class PosControlleur extends Controlleur
{
    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->id_departement)){
                http_response_code(503);
                echo json_encode(array("message" => "id departement inccorect"));
                return;
            }

            if(empty($data->id_superviseur)){
                http_response_code(503);
                echo json_encode(array("message" => "id supperviseur invalide"));
                return;
            }

            if(empty($data->id_banque)){
                http_response_code(503);
                echo json_encode(array("message" => "id banque invalide"));
                return;
            }

            if(empty($data->id_branche)){
                http_response_code(503);
                echo json_encode(array("message" => "id branche invalide"));
                return;
            }

            if(empty($data->imei)){
                http_response_code(503);
                echo json_encode(array("message" => "imei invalide"));
                return;
            }

            if(empty($data->statut)){
                http_response_code(503);
                echo json_encode(array("message" => "statut invalide"));
                return;
            }

            $pos=new Pos();
            $pos->remplire((array)$data);
            $m=$pos->add();
            if($m=="ok"){
                $pos=$pos->lastObjet();
                $pos=$pos->toJson();
                http_response_code(201);
                echo $pos;
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

        if(empty($data->id_departement)){
            http_response_code(503);
            echo json_encode(array("message" => "id departement inccorect"));
            return;
        }

        if(empty($data->id_superviseur)){
            http_response_code(503);
            echo json_encode(array("message" => "id supperviseur invalide"));
            return;
        }

        if(empty($data->id_banque)){
            http_response_code(503);
            echo json_encode(array("message" => "id banque invalide"));
            return;
        }

        if(empty($data->id_branche)){
            http_response_code(503);
            echo json_encode(array("message" => "id branche invalide"));
            return;
        }

        if(empty($data->imei)){
            http_response_code(503);
            echo json_encode(array("message" => "imei invalide"));
            return;
        }

        if(empty($data->statut)){
            http_response_code(503);
            echo json_encode(array("message" => "statut invalide"));
            return;
        }


        $pos=new Pos();
        $pos = $pos->findById($data->id);

        if ($pos == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}"));
            return;
        }

        $pos->remplire((array)$data);
        $m=$pos->update();
        if($m==="ok"){
            $pos=json_encode($pos);
            http_response_code(200);
            echo $pos;
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

        $pos=new Pos();
        $pos=$pos->findById($id);

        if ($pos == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }
        http_response_code(200);
        $pos=json_encode($pos);
        echo $pos;
    }

    public function gets(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $pos=new Pos();
        $liste=$pos->findAll();
        http_response_code(200);
        $pos=json_encode($liste);
        echo $pos;
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

        $obj=new Pos();
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
}
