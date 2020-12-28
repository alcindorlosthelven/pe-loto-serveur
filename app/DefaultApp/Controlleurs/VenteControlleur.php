<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\Client;
use app\DefaultApp\Models\CodeJeux;
use app\DefaultApp\Models\Vendeur;
use app\DefaultApp\Models\Vente;
use app\DefaultApp\Models\VenteEliminer;
use systeme\Controlleur\Controlleur;

class VenteControlleur extends Controlleur
{
    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->no_ticket)){
                http_response_code(503);
                echo json_encode(array("message" => "no ticket invalide"));
                return;
            }

            if(empty($data->id_client)){
                http_response_code(503);
                echo json_encode(array("message" => "id client invalide"));
                return;
            }

            if (!Client::existe($data->id_client)) {
                http_response_code(404);
                echo json_encode(array("message" => "client non trouver pour l'id : {$data->id_client}"));
                return;
            }

            if(empty($data->id_vendeur)){
                http_response_code(503);
                echo json_encode(array("message" => "id vendeur invalide"));
                return;
            }


            if (!Vendeur::existe($data->id_vendeur)) {
                http_response_code(404);
                echo json_encode(array("message" => "Vendeur non trouver pour l'id : {$data->id_vendeur}"));
                return;
            }

            if(empty($data->ref_pos)){
                http_response_code(503);
                echo json_encode(array("message" => "ref pos invalide"));
                return;
            }

            if(empty($data->tid)){
                http_response_code(503);
                echo json_encode(array("message" => "tid invalide"));
                return;
            }

            if(empty($data->sequence)){
                http_response_code(503);
                echo json_encode(array("message" => "no sequence invalide"));
                return;
            }

            if(empty($data->serial)){
                http_response_code(503);
                echo json_encode(array("message" => "no serial invalide"));
                return;
            }

            if(empty($data->date)){
                http_response_code(503);
                echo json_encode(array("message" => "date invalide"));
                return;
            }

            if(empty($data->heure)){
                http_response_code(503);
                echo json_encode(array("message" => "heure invalide"));
                return;
            }

            if(empty($data->paris) or count($data->paris)<=0){
                cj:
                http_response_code(503);
                echo json_encode(array("message" => "liste pari introuvable pour cette vente"));
                return;
            }

            $cjeux=false;
            foreach ($data->paris as $pari){
                $cjeux=CodeJeux::existe($pari->id_code_jeux);
            }

            if($cjeux===true) {
                $paris=json_encode($data->paris);
                $obj=new Vente();
                $obj->remplire((array)$data);
                $obj->setParis($paris);
                $obj->setEliminer("non");
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
            }else{
                goto cj;
            }
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function update(){
        try{
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

            $obj=new Vendeur();
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

        $obj=new Vente();
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
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");

        $obj=new Vente();
        $liste=$obj->findAll();
        http_response_code(200);
        $obj=json_encode($liste);
        echo $obj;
    }

    public function eliminer(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: access");
            header("Access-Control-Allow-Methods: GET");
            header("Access-Control-Allow-Credentials: true");
            header("Content-Type: application/json; charset=UTF-8");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->no_ticket)){
                http_response_code(503);
                echo json_encode(array("message" => "no ticket invalide"));
                return;
            }

            if(empty($data->tid)){
                http_response_code(503);
                echo json_encode(array("message" => "tid invalide"));
                return;
            }

            if(empty($data->serial)){
                http_response_code(503);
                echo json_encode(array("message" => "serial invalide"));
                return;
            }

            if(empty($data->tirage)){
                http_response_code(503);
                echo json_encode(array("message" => "tirage invalide"));
                return;
            }

            if(empty($data->motif)){
                http_response_code(503);
                echo json_encode(array("message" => "motif invalide"));
                return;
            }


            $obj=new Vente();
            $obj=$obj->findByCritere($data->no_ticket,$data->tid,$data->serial,$data->tirage);

            if ($obj==null) {
                http_response_code(404);
                echo json_encode(array("message" => "Objet non trouver verifier les informations suivants<br>Tiket : {$data->no_ticket} <br> Tid : {$data->tid} <br>Serial : {$data->serial} <br>Tirage : {$data->tirage}"));
                return;
            }

            $venteEliminer=new VenteEliminer();
            $venteEliminer->setIdVente($obj->getId());
            $venteEliminer->setMotif($data->motif);
            $venteEliminer->setStatus("en cours");

            $m=$venteEliminer->add();
            if($m=="ok"){
                $venteEliminer=$venteEliminer->lastObjet();
                $venteEliminer->message="enregistrer avec success";
                $venteEliminer=$venteEliminer->toJson();
                http_response_code(200);
                echo $venteEliminer;
                return;
            }

            http_response_code(503);
            echo json_encode(array("message" => $m));
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function confimerElimination(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"));
        if(empty($data->id_vente_eliminer)){
            http_response_code(503);
            echo json_encode(array("message" => "id vente eliminer invalide"));
            return;
        }

        $vente=new Vente();
        $obj=new VenteEliminer();
        $obj=$obj->findById($data->id_vente_eliminer);

        if ($obj==null) {
            http_response_code(404);
            echo json_encode(array("message" => "Objet non trouver pour l'id : {$data->id_vente_eliminer}"));
            return;
        }

        $vente=$vente->findById($obj->id_vente);
        $obj->setStatus("terminer");
        $vente->setEliminer("oui");

        $mup=$obj->update();
        if($mup=="ok"){
            $mv=$vente->update();
            if($mv=="ok"){
                http_response_code(200);
                $obj=$obj->toJson();
                echo $obj;
            }
            http_response_code(503);
            echo json_encode(array("message" => $mv));
            return;
        }

        http_response_code(503);
        echo json_encode(array("message" => $mup));

    }
}