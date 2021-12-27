<?php


namespace app\DefaultApp\Controlleurs;
use app\DefaultApp\Models\Client;
use app\DefaultApp\Models\ClientCompteTransaction;
use app\DefaultApp\Models\CompteClient;
use app\DefaultApp\Models\TransactionClient;

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

            if(empty($data->pseudo)){
                http_response_code(503);
                echo json_encode(array("message" => "identifiant invalide"));
                return;
            }

            $password=md5($data->telephone);
            $connect = "non";
            $obj=new Client();
            $obj->remplire((array)$data);
            $obj->setPassword($password);
            $obj->setConnect($connect);
            $m=$obj->add();
            if($m=="ok"){
                $obj=$obj->lastObjet();
                $compteClient=new CompteClient();
                $compteClient->id_client=$obj->id;
                $compteClient->balance_jeux="0.00";
                $compteClient->balance_retrait="0.00";
                $compteClient->add();
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

        $compte=new CompteClient();
        $compte=$compte->rechercher($obj->id);
        if($compte!=null){
            $t=ClientCompteTransaction::listeByCompte($compte->id);
            $compte->transactions=$t;
        }
        $obj->compte=$compte;
        http_response_code(200);
        $obj=json_encode($obj);
        echo $obj;
    }

    public function gets(){
        $obj=new Client();
        $liste=$obj->findAll();
        foreach ($liste as $index=>$value){
            $compte=new CompteClient();
            $compte=$compte->rechercher($value->id);
            if($compte!=null){
                $transactions=ClientCompteTransaction::listeByCompte($compte->id);
                $compte->transactions=$transactions;
            }
            $liste[$index]->compte=$compte;
        }
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

    public function depotCredit(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"));
        $con=Client::connection();
        $con->beginTransaction();
        try{
            $id_client=$data->id_client;
            $montant=floatval($data->montant);
            $montantDebut=CompteClient::getBalanceCredit($id_client);
            $montantNouveau=$montantDebut+$montant;
            $m=CompteClient::depotCredit($id_client,$montant);
            if($m=="ok"){
                $inc=CompteClient::getInfoCompte($id_client);
                $trasaction=new ClientCompteTransaction();
                $trasaction->id_compte=$inc->id;
                $trasaction->type="depot";
                $trasaction->date=date("Y-m-d");
                $trasaction->heure=date("H:i:s");
                $trasaction->montant=$montant;
                $trasaction->montant_avant=$montantDebut;
                $trasaction->montant_apres=$montantNouveau;
                $trasaction->message="depot sur compte de jeux";
                $mm=$trasaction->add();
                if($mm=="ok"){
                    $con->commit();
                    http_response_code(200);
                    echo json_encode(array("message"=>"Depot effectuer avec success"));
                }else{
                    $con->rollBack();
                    http_response_code(503);
                    echo json_encode(array("message"=>$m));
                }
            }else{
                $con->rollBack();
                http_response_code(503);
                echo json_encode(array("message"=>$m));
            }
        }catch (\Exception $ex){
            $con->rollBack();
            http_response_code(503);
            echo json_encode(array("message"=>$ex->getMessage()));
        }
    }


    public function retraitBalance(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"));
        $con=Client::connection();
        $con->beginTransaction();
        try{
            $id_client=$data->id_client;
            $montant=floatval($data->montant);
            $montantDebut=CompteClient::getBalance($id_client);
            $montantNouveau=$montantDebut-$montant;
            $m=CompteClient::retrait($id_client,$montant);
            if($m=="ok"){
                $inc=CompteClient::getInfoCompte($id_client);
                $trasaction=new ClientCompteTransaction();
                $trasaction->id_compte=$inc->id;
                $trasaction->type="retrait";
                $trasaction->date=date("Y-m-d");
                $trasaction->heure=date("H:i:s");
                $trasaction->montant=$montant;
                $trasaction->montant_avant=$montantDebut;
                $trasaction->montant_apres=$montantNouveau;
                $trasaction->message="retrait sur compte retrait";
                $mm=$trasaction->add();
                if($mm=="ok"){
                    $con->commit();
                    http_response_code(200);
                    echo json_encode(array("message"=>"retrait effectuer avec success"));
                }else{
                    $con->rollBack();
                    http_response_code(503);
                    echo json_encode(array("message"=>$m));
                }
            }else{
                $con->rollBack();
                http_response_code(503);
                echo json_encode(array("message"=>$m));
            }
        }catch (\Exception $ex){
            $con->rollBack();
            http_response_code(503);
            echo json_encode(array("message"=>$ex->getMessage()));
        }
    }
}
