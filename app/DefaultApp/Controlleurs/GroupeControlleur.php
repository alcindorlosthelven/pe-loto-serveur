<?php


namespace app\DefaultApp\Controlleurs;

use app\DefaultApp\Models\Departement;
use app\DefaultApp\Models\Groupe;
use systeme\Controlleur\Controlleur;

class GroupeControlleur extends Controlleur
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

            if(empty($data->id_departement)){
                http_response_code(503);
                echo json_encode(array("message" => "departement invalide"));
                return;
            }

            $ob=new Groupe();
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

        if(empty($data->nom)){
            http_response_code(503);
            echo json_encode(array("message" => "nom invalide"));
            return;
        }

        if(empty($data->id_departement)){
            http_response_code(503);
            echo json_encode(array("message" => "departement invalide"));
            return;
        }


        $ob=new Groupe();
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

        $ob=new Groupe();
        $ob=$ob->findById($id);

        if ($ob == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }
        $id_departement=$ob->id_departement;
        $de=new Departement();
        $de=$de->findById($id_departement);
        $ob->departement=$de;

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

        $ob=new Groupe();
        $liste=$ob->findAll();

        foreach ($liste as $i=>$value){
            $id_departement=$value->id_departement;
            $de=new Departement();
            $de=$de->findById($id_departement);
            $liste[$i]->departement=$de;
        }

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

        $obj=new Groupe();
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
