<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\Banque;
use app\DefaultApp\Models\Branche;
use app\DefaultApp\Models\Departement;
use app\DefaultApp\Models\Groupe;
use app\DefaultApp\Models\Pos;
use app\DefaultApp\Models\Reseau;
use app\DefaultApp\Models\Utilisateur;
use app\DefaultApp\Models\Vendeur;
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

            if(empty($data->imei)){
                http_response_code(503);
                echo json_encode(array("message" => "imei invalide"));
                return;
            }

            $pos=new Pos();
            $pos->remplire((array)$data);
            $pos->statut="desactiver";
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

        if(empty($data->imei)){
            http_response_code(503);
            echo json_encode(array("message" => "imei invalide"));
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
        $vendeur=new Vendeur();
        $vendeur=$vendeur->rechercherParPos($pos->id);
        $pos->vendeur=$vendeur;
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
        foreach($liste as $i=>$value){
            $vendeur=new Vendeur();
            $vendeur=$vendeur->rechercherParPos($liste[$i]->id);
            $liste[$i]->vendeur=$vendeur;
        }
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

    public function activer($id){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: POST");
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

        $obj->statut="actif";
        $m=$obj->update();
        if($m){
            http_response_code(200);
            echo json_encode(array("message"=>"activé avec success"));
            return;
        }

        http_response_code(503);
        echo json_encode(array("message" => $m));

    }

    public function desactiver($id){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: POST");
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

        $obj->statut="inactif";
        $m=$obj->update();
        if($m){
            http_response_code(200);
            echo json_encode(array("message"=>"desactivé avec success"));
            return;
        }

        http_response_code(503);
        echo json_encode(array("message" => $m));

    }

    public function fermer($id){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: POST");
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

        $obj->statut="eteint";
        $m=$obj->update();
        if($m){
            http_response_code(200);
            echo json_encode(array("message"=>"fermé avec success"));
            return;
        }

        http_response_code(503);
        echo json_encode(array("message" => $m));

    }

    public function updatePosition(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: PUT");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $data = json_decode(file_get_contents("php://input"));

        if(empty($data->imei)){
            http_response_code(503);
            echo json_encode(array("message" => "imei invalide"));
            return;
        }

        if(empty($data->longitude)){
            http_response_code(503);
            echo json_encode(array("message" => "longitude invalide"));
            return;
        }

        if(empty($data->latitude)){
            http_response_code(503);
            echo json_encode(array("message" => "latitude invalide"));
            return;
        }

        $pos=new Pos();
        $m=$pos->updatePosition($data->imei,$data->latitude,$data->longitude);
        if($m=="ok"){
            $pos=json_encode(array("statut"=>"ok","message"=>"position update avec success"));
            http_response_code(200);
            echo $pos;
            return;
        }
        http_response_code(503);
        echo json_encode(array("message" => $m,"statut"=>"no"));
    }

}
