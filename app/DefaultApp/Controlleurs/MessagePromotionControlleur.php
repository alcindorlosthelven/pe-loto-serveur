<?php


namespace app\DefaultApp\Controlleurs;


use app\DefaultApp\Models\MessagePromotion;
use app\DefaultApp\Models\PushNotification;
use app\DefaultApp\Models\Vendeur;
use systeme\Controlleur\Controlleur;

class MessagePromotionControlleur extends Controlleur
{
    public function add(){
        try{
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));

            if(empty($data->type)){
                http_response_code(503);
                echo json_encode(array("message" => "type invalide"));
                return;
            }

            if(empty($data->titre)){
                http_response_code(503);
                echo json_encode(array("message" => "titre invalide"));
                return;
            }

            if(empty($data->contenue)){
                http_response_code(503);
                echo json_encode(array("message" => "contenue invalide"));
                return;
            }

            $ob=new MessagePromotion();
            $ob->remplire((array)$data);
            $ob->date=date("Y-m-d");
            $ob->heure=date("H:i:s");
            $listeToken=Vendeur::listeToken();
            if(count($listeToken)>0){
                $m=$ob->add();
                if($m=="ok"){
                    PushNotification::envoyer($listeToken,$data->titre,$data->contenue);
                    $ob=$ob->lastObjet();
                    $ob->message=count($listeToken)." messages envoyé";
                    $ob=$ob->toJson();
                    http_response_code(200);
                    echo $ob;
                    return;
                }
                http_response_code(503);
                echo json_encode(array("message" => $m));
            }else{
                $m=$ob->add();
                if($m=="ok"){
                    $ob=$ob->lastObjet();
                    $ob->message="Enregistrer avec success";
                    $ob=$ob->toJson();
                    http_response_code(200);
                    echo $ob;
                    return;
                }
                http_response_code(503);
                echo json_encode(array("message" => "Pas de token trouvé dans la base de donnée"));
            }
        }catch (\Exception $ex){
            http_response_code(503);
            echo json_encode(array("message" => $ex->getMessage()));
        }

    }

    public function listeMessage(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $pos=new MessagePromotion();
        $liste=$pos->listeMessage();
        http_response_code(200);
        $pos=json_encode($liste);
        echo $pos;
    }

    public function listePromotion(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header("Content-Type: application/json; charset=UTF-8");
        $pos=new MessagePromotion();
        $liste=$pos->listePromotions();
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

        $obj=new MessagePromotion();
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
