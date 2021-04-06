<?php


namespace app\DefaultApp\Controlleurs;

use app\DefaultApp\Models\LotGagnant;
use app\DefaultApp\Models\Tirage;
use app\DefaultApp\Models\Vente;
use app\DefaultApp\Models\VenteEliminer;
use systeme\Controlleur\Controlleur;

class LotGagnantControlleur extends Controlleur
{
    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->date)){
                http_response_code(503);
                echo json_encode(array("message" => "Date invalide"));
                return;
            }

            if(empty($data->tirage)){
                http_response_code(503);
                echo json_encode(array("message" => "Tirage invalide"));
                return;
            }

            if(empty($data->lot1)){
                http_response_code(503);
                echo json_encode(array("message" => "Lot1 invalide"));
                return;
            }

            if(empty($data->lot2)){
                http_response_code(503);
                echo json_encode(array("message" => "Lot2 invalide"));
                return;
            }

            if(empty($data->lot3)){
                http_response_code(503);
                echo json_encode(array("message" => "Lot3 invalide"));
                return;
            }

            if(empty($data->loto3)){
                http_response_code(503);
                echo json_encode(array("message" => "Loto3 invalide"));
                return;
            }


            if(Tirage::isTirageEncour($data->tirage)){
                http_response_code(503);
                echo json_encode(array("message" => "Imposible d'ajouter le lot gagnant, le tirage choisie est en cours"));
                return;
            }

            $obj=new LotGagnant();
            $obj->remplire((array)$data);
            $m=$obj->add();
            if($m=="ok"){
                Vente::updateBilletForLotGagnant($data->date,$data->tirage);
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

        if(empty($data->date)){
            http_response_code(503);
            echo json_encode(array("message" => "Date invalide"));
            return;
        }

        if(empty($data->tirage)){
            http_response_code(503);
            echo json_encode(array("message" => "Tirage invalide"));
            return;
        }

        if(empty($data->lot1)){
            http_response_code(503);
            echo json_encode(array("message" => "Lot1 invalide"));
            return;
        }

        if(empty($data->lot2)){
            http_response_code(503);
            echo json_encode(array("message" => "Lot2 invalide"));
            return;
        }

        if(empty($data->lot3)){
            http_response_code(503);
            echo json_encode(array("message" => "Lot3 invalide"));
            return;
        }

        if(empty($data->loto3)){
            http_response_code(503);
            echo json_encode(array("message" => "Loto3 invalide"));
            return;
        }

        $obj=new LotGagnant();
        $obj = $obj->findById($data->id);

        if ($obj == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}"));
            return;
        }

        $obj->remplire((array)$data);
        $m=$obj->update();
        if($m==="ok"){
            Vente::updateBilletForLotGagnant($data->date,$data->tirage);
            $codeJeux=json_encode($obj);
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

        $obj=new LotGagnant();
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

        $obj=new LotGagnant();
        $liste=$obj->findAll();
        http_response_code(200);
        $obj=json_encode($liste);
        echo $obj;
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

        $obj=new LotGagnant();
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

    public function getParDateTirage(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        if(isset($_GET['date']) and isset($_GET['tirage'])){
            $obj=new LotGagnant();
            $obj=$obj->rechercherParDateTirage($_GET['date'],$_GET['tirage']);
            if ($obj == null) {
                http_response_code(404);
                echo json_encode(array("message" => "Objet non trouver"));
                return;
            }

            http_response_code(200);
            $obj=json_encode($obj);
            echo $obj;
        }else{
            http_response_code(404);
            echo json_encode(array("message" => "Date ou Tirage ou lotterie  incorrect"));
            return;
        }
    }

    public function getBilletGagnant(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        if(isset($_GET['date']) and isset($_GET['tirage'])){
            if(isset($_GET['id_vendeur'])){
                $listeVenteGagnant=Vente::getBilletGagnant($_GET['date'],$_GET['tirage'],$_GET['id_vendeur']);
            }else{
                $listeVenteGagnant=Vente::getBilletGagnant($_GET['date'],$_GET['tirage']);
            }
            http_response_code(200);
            echo json_encode($listeVenteGagnant);
        }else{
            http_response_code(404);
            echo json_encode(array("message" => "Date ou Tirage incorrect"));
            return;
        }
    }

    public function getBilletGagnantPayer(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        if(isset($_GET['date']) and isset($_GET['tirage'])){
            if(isset($_GET['id_vendeur'])){
                $listeVenteGagnant=Vente::getBilletGagnantPayer($_GET['date'],$_GET['tirage'],$_GET['id_vendeur']);
            }else{
                $listeVenteGagnant=Vente::getBilletGagnantPayer($_GET['date'],$_GET['tirage']);
            }
            http_response_code(200);
            echo json_encode($listeVenteGagnant);
        }else{
            http_response_code(404);
            echo json_encode(array("message" => "Date ou Tirage incorrect"));
            return;
        }
    }

}
