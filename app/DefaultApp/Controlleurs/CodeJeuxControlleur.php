<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\CodeJeux;
use systeme\Controlleur\Controlleur;
use systeme\Model\Model;

class CodeJeuxControlleur extends Controlleur
{
    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->code)){
                http_response_code(503);
                echo json_encode(array("message" => "code invalide"));
                return;
            }
            $codeJeux=new CodeJeux();
            $codeJeux->remplire((array)$data);
            $m=$codeJeux->add();
            if($m=="ok"){
                $codeJeux=$codeJeux->lastObjet();
                $codeJeux->message="enregistrer avec success";
                $codeJeux=$codeJeux->toJson();
                http_response_code(200);
                echo $codeJeux;
                return;
            }
            http_response_code(503);
            echo json_encode(array("message" => $m, "status" => 503));
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage(), "status" => 503));
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

        if(empty($data->code)){
            http_response_code(503);
            echo json_encode(array("message" => "code invalide"));
            return;
        }

        $codeJeux=new CodeJeux();
        $codeJeux = $codeJeux->findById($data->id);

        if ($codeJeux == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}","status"=>503));
            return;
        }

        $codeJeux->remplire((array)$data);
        $m=$codeJeux->update();
        if($m==="ok"){
            $codeJeux->message="modifer avec success";
            $codeJeux=json_encode($codeJeux);
            http_response_code(200);
            echo $codeJeux;
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

        $codeJeux=new CodeJeux();
        $codeJeux=$codeJeux->findById($id);

        if ($codeJeux == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }
        http_response_code(200);
        $codeJeux=json_encode($codeJeux);
        echo $codeJeux;
    }

    public function gets(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        $codeJeux=new CodeJeux();
        $liste=$codeJeux->findAll();
        http_response_code(200);
        $codeJeux=json_encode($liste);
        echo $codeJeux;
    }

}