<?php


namespace app\DefaultApp\Controlleurs;
use app\DefaultApp\Models\Client;

class ClientControlleur extends BaseControlleur
{
    public function add(){
        try{
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
        $obj=new Client();
        $liste=$obj->findAll();
        http_response_code(200);
        $obj=json_encode($liste);
        echo $obj;
    }

    public function delete($id){
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
        $v=new Client();
        $obj=$v->total();
        http_response_code(200);
        $obj = json_encode($obj);
        echo $obj;
    }

    public function saveToken(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"));
        $m=Client::saveToken($data->id,$data->token);
        if($m==="ok"){
            echo json_encode(array("message"=>"token save avec success"));
        }else{
            echo json_encode(array("message"=>"echek de sauvegarde"));
        }
    }

}
