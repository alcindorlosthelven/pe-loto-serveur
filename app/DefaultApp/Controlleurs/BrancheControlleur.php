<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\Branche;
use app\DefaultApp\Models\Reseau;
use systeme\Controlleur\Controlleur;
use systeme\Model\Utilisateur;

class BrancheControlleur extends Controlleur
{
    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->branche)){
                http_response_code(503);
                echo json_encode(array("message" => "code invalide"));
                return;
            }

            if(empty($data->id_supperviseur)){
                http_response_code(503);
                echo json_encode(array("message" => "supperviseur invalide"));
                return;
            }

            if(empty($data->addresse)){
                http_response_code(503);
                echo json_encode(array("message" => "addresse invalide"));
                return;
            }

            if(empty($data->telephone)){
                http_response_code(503);
                echo json_encode(array("message" => "addresse telephone"));
                return;
            }

            $ob=new Branche();
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

        if(empty($data->branche)){
            http_response_code(503);
            echo json_encode(array("message" => "code invalide"));
            return;
        }

        if(empty($data->id_supperviseur)){
            http_response_code(503);
            echo json_encode(array("message" => "supperviseur invalide"));
            return;
        }

        if(empty($data->addresse)){
            http_response_code(503);
            echo json_encode(array("message" => "addresse invalide"));
            return;
        }

        if(empty($data->telephone)){
            http_response_code(503);
            echo json_encode(array("message" => "addresse telephone"));
            return;
        }


        $ob=new Branche();
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

        $ob=new Branche();
        $ob=$ob->findById($id);

        if ($ob == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$id}"));
            return;
        }

        $su=new \app\DefaultApp\Models\Utilisateur();
        $su=$su->findById($ob->id_supperviseur);
        $ob->supperviseur=$su;

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

        $ob=new Branche();
        $liste=$ob->findAll();
        foreach ($liste as $i=>$value){
            $su=new \app\DefaultApp\Models\Utilisateur();
            $su=$su->findById($value->id_supperviseur);
            $liste[$i]->supperviseur=$su;
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

        $obj=new Branche();
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
