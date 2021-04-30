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

            if(empty($data->id_reseau)){
                http_response_code(503);
                echo json_encode(array("message" => "id reseau invalide"));
                return;
            }

            if(empty($data->id_groupe)){
                http_response_code(503);
                echo json_encode(array("message" => "id groupe invalide"));
                return;
            }

            if(empty($data->id_departement)){
                http_response_code(503);
                echo json_encode(array("message" => "id departement invalide"));
                return;
            }


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

        if(empty($data->id_reseau)){
            http_response_code(503);
            echo json_encode(array("message" => "id reseau invalide"));
            return;
        }

        if(empty($data->id_groupe)){
            http_response_code(503);
            echo json_encode(array("message" => "id groupe invalide"));
            return;
        }

        if(empty($data->id_departement)){
            http_response_code(503);
            echo json_encode(array("message" => "id departement invalide"));
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

        $b=new Banque();
        $d=new Departement();
        $br=new Branche();
        $su=new Utilisateur();
        $gr=new Groupe();
        $reseau=new Reseau();
        $vendeur=new Vendeur();

        $id_superviseur=$pos->id_superviseur;
        $id_branch=$pos->id_branche;
        $id_banque=$pos->id_banque;
        $id_departement=$pos->id_departement;
        $id_groupe=$pos->id_groupe;
        $id_reseau=$pos->id_reseau;

        $b=$b->findById($id_banque);
        $br=$br->findById($id_branch);
        $su=$su->findById($id_superviseur);
        $d=$d->findById($id_departement);
        $gr=$gr->findById($id_groupe);
        $reseau=$reseau->findById($id_reseau);
        $vendeur=$vendeur->rechercherParPos($pos->id);
        $pos->vendeur=$vendeur;
        $pos->superviseur=$su;
        $pos->branche=$br;
        $pos->banque=$b;
        $pos->departement=$d;
        $pos->groupe=$gr;
        $pos->reseau=$reseau;

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
            $b=new Banque();
            $d=new Departement();
            $br=new Branche();
            $su=new Utilisateur();
            $gr=new Groupe();
            $reseau=new Reseau();
            $vendeur=new Vendeur();

            $id_superviseur=$value->id_superviseur;
            $id_branch=$value->id_branche;
            $id_banque=$value->id_banque;
            $id_departement=$value->id_departement;
            $id_groupe=$value->id_groupe;
            $id_reseau=$value->id_reseau;

            $b=$b->findById($id_banque);
            $br=$br->findById($id_branch);
            $su=$su->findById($id_superviseur);
            $d=$d->findById($id_departement);
            $gr=$gr->findById($id_groupe);
            $reseau=$reseau->findById($id_reseau);
            $vendeur=$vendeur->rechercherParPos($liste[$i]->id);
            $liste[$i]->vendeur=$vendeur;
            $liste[$i]->superviseur=$su;
            $liste[$i]->branche=$br;
            $liste[$i]->banque=$b;
            $liste[$i]->departement=$d;
            $liste[$i]->groupe=$gr;
            $liste[$i]->reseau=$reseau;
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
