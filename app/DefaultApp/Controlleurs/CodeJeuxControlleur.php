<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\DefaultApp;
use app\DefaultApp\Models\BouleBloquer;
use app\DefaultApp\Models\Branche;
use app\DefaultApp\Models\CodeJeux;
use app\DefaultApp\Models\NumeroControler;
use app\DefaultApp\Models\Prime;
use app\DefaultApp\Models\Vendeur;
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

            if(empty($data->description)){
                http_response_code(503);
                echo json_encode(array("message" => "description invalide"));
                return;
            }

            if(empty($data->gagne)){
                http_response_code(503);
                echo json_encode(array("message" => "Gagne invalide"));
                return;
            }



            $codeJeux=new CodeJeux();
            $codeJeux->remplire((array)$data);
            $m=$codeJeux->add();
            if($m=="ok"){
                $codeJeux=$codeJeux->lastObjet();
                $codeJeux=$codeJeux->toJson();
                http_response_code(200);
                echo $codeJeux;
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

        if(empty($data->code)){
            http_response_code(503);
            echo json_encode(array("message" => "code invalide"));
            return;
        }

        if(empty($data->description)){
            http_response_code(503);
            echo json_encode(array("message" => "description invalide"));
            return;
        }


        if(empty($data->gagne)){
            http_response_code(503);
            echo json_encode(array("message" => "Gagne invalide"));
            return;
        }

        $codeJeux=new CodeJeux();
        $codeJeux = $codeJeux->findById($data->id);

        if ($codeJeux == null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id}"));
            return;
        }

        $codeJeux->remplire((array)$data);
        $m=$codeJeux->update();
        if($m==="ok"){
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

        $obj=new CodeJeux();
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

    public function addLimite(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));
            foreach ($data as $cj){
                $dest=new CodeJeux();
                $c=DefaultApp::cast($dest,$cj);
                $c->update();
            }
            http_response_code(200);
            echo json_encode(array("message" => "Fait avec success"));
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function addPrime(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));
            $id_branche=$data->id_branche;
            $primes=json_encode($data->primes);
            $branche=new Branche();
            $branche=$branche->findById($id_branche);
            $branche->prime=$primes;
            $m=$branche->update();
            if($m=="ok"){
                http_response_code(200);
                echo json_encode(array("message"=>"Fait avec success"));
                return;
            }
            http_response_code(503);
            echo json_encode(array("message" => $m));
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function getsPrime(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));
            $id_branche=$data->id_branche;
            $branche=new Branche();
            $branche=$branche->findById($id_branche);
            $liste=json_decode($branche->prime);
            http_response_code(200);
            $codeJeux=json_encode($liste);
            echo $codeJeux;
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function addNumero(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));
            $id_branche=$data->id_branche;
            $limite_numero=json_encode($data->limite_numero);
            $vente_general=$data->vente_generale;
            $numero=new NumeroControler();
            $numero->branche=$id_branche;
            $numero->limite=$limite_numero;
            $numero->limite_vente=$vente_general;
            $m=$numero->add();
            if($m=="ok"){
                http_response_code(200);
                echo json_encode(array("message"=>"Fait avec success"));
                return;
            }
            http_response_code(503);
            echo json_encode(array("message" => $m));
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function getsNumero(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));
            $id_branche=$data->id_branche;
            $codeJeux=new NumeroControler();
            $liste=$codeJeux->lister($id_branche);
            http_response_code(200);
            $codeJeux=json_encode($liste);
            echo $codeJeux;
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function addNumeroBloquer(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->boule)){
                http_response_code(503);
                echo json_encode(array("message" => "boule invalide"));
                return;
            }

            $codeJeux=new BouleBloquer();
            $codeJeux->remplire((array)$data);
            $m=$codeJeux->add();
            if($m=="ok"){
                $codeJeux=$codeJeux->lastObjet();
                $codeJeux=$codeJeux->toJson();
                http_response_code(200);
                echo $codeJeux;
                return;
            }
            http_response_code(503);
            echo json_encode(array("message" => $m));
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function numeroBloquer(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $b=new BouleBloquer();
            $liste=$b->findAll();
            http_response_code(200);
            echo json_encode($liste);
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }
    }

    public function supprimerNumeroBloquer($id){
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

        $obj=new BouleBloquer();
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
