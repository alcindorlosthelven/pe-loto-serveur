<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\PosVendeur;
use systeme\Controlleur\Controlleur;

class PosVendeurControlleur extends Controlleur
{
    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->id_vendeur)){
                http_response_code(503);
                echo json_encode(array("message" => "id vendeur invalide"));
                return;
            }

            if(empty($data->id_pos)){
                http_response_code(503);
                echo json_encode(array("message" => "id pos invalide"));
                return;
            }


            $ob=new PosVendeur();
            $ob->remplire((array)$data);
            $m=$ob->add();
            if($m=="ok"){
                $ob=$ob->lastObjet();
                $ob=$ob->toJson();
                http_response_code(200);
                echo $ob;
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

        if(empty($data->id_vendeur)){
            http_response_code(503);
            echo json_encode(array("message" => "id vendeur invalide"));
            return;
        }

        if(empty($data->id_pos)){
            http_response_code(503);
            echo json_encode(array("message" => "id pos invalide"));
            return;
        }


        $ob=new PosVendeur();
        $ob = $ob->findById($data->id);

        if ($ob == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}"));
            return;
        }

        $ob->remplire((array)$data);
        $m=$ob->update();
        if($m==="ok"){
            $ob=json_encode($ob);
            http_response_code(200);
            echo $ob;
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

        $ob=new PosVendeur();
        $ob=$ob->findById($id);

        if ($ob == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }
        http_response_code(200);
        $ob=json_encode($ob);
        echo $ob;
    }

    public function gets(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        $ob=new PosVendeur();
        $liste=$ob->findAll();
        http_response_code(200);
        $ob=json_encode($liste);
        echo $ob;
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

        $obj=new PosVendeur();
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
