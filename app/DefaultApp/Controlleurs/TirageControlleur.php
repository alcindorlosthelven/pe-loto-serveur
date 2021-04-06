<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\Tirage;
use systeme\Controlleur\Controlleur;

class TirageControlleur extends Controlleur
{
    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->tirage)){
                http_response_code(503);
                echo json_encode(array("message" => "tirage invalide"));
                return;
            }

            $obj=new Tirage();
            $obj->remplire((array)$data);
            $obj->setStatut("n/a");
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

        if(empty($data->tirage)){
            http_response_code(503);
            echo json_encode(array("message" => "tirage invalide"));
            return;
        }

        if(empty($data->statut)){
            http_response_code(503);
            echo json_encode(array("message" => "statut invalide"));
            return;
        }

        $obj=new Tirage();
        $obj = $obj->findById($data->id);

        if ($obj == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}"));
            return;
        }

        $obj->remplire((array)$data);
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

        $obj=new Tirage();
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


        $obj=new Tirage();
        if(isset($_GET['encours'])){
            http_response_code(200);
            $liste=$obj->listeEncours();
            echo json_encode($liste);
        }else{
            $liste=$obj->findAll();
            http_response_code(200);
            $obj=json_encode($liste);
            echo $obj;
        }

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

        $obj=new Tirage();
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
