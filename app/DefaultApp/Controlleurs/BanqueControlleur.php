<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\Banque;
use systeme\Controlleur\Controlleur;
use systeme\Model\Model;

class BanqueControlleur extends Controlleur
{
    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->banque)){
                http_response_code(503);
                echo json_encode(array("message" => "banque inccorect"));
                return;
            }

            if(empty($data->latitude)){
                http_response_code(503);
                echo json_encode(array("message" => "latitude invalide"));
                return;
            }

            if(empty($data->longitude)){
                http_response_code(503);
                echo json_encode(array("message" => "longitude invalide"));
                return;
            }


            $banque=new Banque();
            $banque->remplire((array)$data);
            $m=$banque->add();
            if($m=="ok"){
                $banque=$banque->lastObjet();
                $banque=$banque->toJson();
                http_response_code(201);
                echo $banque;
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

        if(empty($data->banque)){
            http_response_code(503);
            echo json_encode(array("message" => "banque inccorect"));
            return;
        }

        if(empty($data->latitude)){
            http_response_code(503);
            echo json_encode(array("message" => "latitude invalide"));
            return;
        }

        if(empty($data->longitude)){
            http_response_code(503);
            echo json_encode(array("message" => "longitude invalide"));
            return;
        }


        $banque=new Banque();
        $banque = $banque->findById($data->id);

        if ($banque == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}"));
            return;
        }

        $banque->remplire((array)$data);
        $m=$banque->update();
        if($m==="ok"){
            $banque=json_encode($banque);
            http_response_code(200);
            echo $banque;
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

        $banque=new Banque();
        $banque=$banque->findById($id);

        if ($banque == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }
        http_response_code(200);
        $banque=json_encode($banque);
        echo $banque;
    }

    public function gets(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $banque=new Banque();
        $liste=$banque->findAll();
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

        $obj=new Banque();
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
