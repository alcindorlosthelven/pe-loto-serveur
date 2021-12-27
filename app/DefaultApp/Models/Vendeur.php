<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Vendeur extends Model
{
    public $id, $nom, $prenom, $telephone, $sexe, $objet, $pseudo, $password, $connect,$addresse,$id_branche;

    public function __construct($objet = "vendeur")
    {
        $this->objet = $objet;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getConnect()
    {
        return $this->connect;
    }

    /**
     * @param mixed $connect
     */
    public function setConnect($connect): void
    {
        $this->connect = $connect;
    }


    /**
     * @return mixed|string
     */
    public function getObjet(): mixed
    {
        return $this->objet;
    }

    /**
     * @param mixed|string $objet
     */
    public function setObjet(mixed $objet): void
    {
        $this->objet = $objet;
    }


    /**
     * @return mixed
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param mixed $sexe
     */
    public function setSexe($sexe): void
    {
        $this->sexe = $sexe;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
    }


    public static function existe($id)
    {
        $cj = new Vendeur();
        $cj = $cj->findById($id);
        if ($cj !== null) {
            return true;
        }
        return false;
    }

    public static function setConnection($id)
    {
        try {
            $id_session = md5(sha1(uniqid('', true)));
            $con = self::connection();
            $req = "UPDATE vendeur SET connect=:connect WHERE id=:id";
            $stmt = $con->prepare($req);
            if ($stmt->execute(array(
                ":connect" => "oui",
                ":id" => $id
            ))
            ) {
                $_SESSION['id_session'] = $id_session;
                return "ok";
            } else {
                return "no";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public static function login($user_name, $password)
    {
        $password = md5($password);
        try {
            $con = self::connection();
            $req = "SELECT *FROM vendeur WHERE pseudo=:pseudo AND password=:password";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":pseudo" => $user_name,
                ":password" => $password
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            if (count($data) > 0) {
                $pos_vendeur = PosVendeur::rechercherParVendeur($data[0]->id);
                if ($pos_vendeur == null) {
                    return
                        array(
                            "message" => "Aucun POS lié a votre compte, contacter l'administration",
                            "statut" => "no"
                        );
                }

                $pos = new Pos();
                $pos = $pos->findById($pos_vendeur->id_pos);
                if ($pos->statut !== 'actif') {
                    return
                        array(
                            "message" => "POS desactiver ou inactif , contacter l'administration",
                            "statut" => "no"
                        );
                }
                self::setConnection($data[0]->getId());
                $data[0]->statut = "ok";
                $data[0]->pos = $pos;
                $data[0]->setConnect("oui");
                return
                    array(
                        "result" =>$data[0],
                        "message" => "Email ou mot de passe incorrect",
                        "statut" => "ok"
                    );
            } else {
                return
                    array(
                        "message" => "Identifiant ou mot de passe incorrect",
                        "statut" => "no"
                    );
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }

    public static function total()
    {
        $con = self::connection();
        $req = "select *from vendeur";
        $stmt = $con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function listerParBranche($id_branche)
    {
        $con = self::connection();
        $req = "select *from vendeur where id_branche=:id_branche";
        $stmt = $con->prepare($req);
        $stmt->execute(array(":id_branche" => $id_branche));
        $datas = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        return $datas;
    }

    public function rechercherParPos($idPos)
    {
        $con = self::connection();
        $req = "select v.id,v.nom,v.prenom,v.sexe,v.telephone,v.pseudo,v.password,v.connect,v.objet,v.id_branche
        from vendeur as v,pos_vendeur as pv ,pos where 
        v.id=pv.id_vendeur and pos.id=pv.id_pos and pos.id=:id_pos";
        $stmt = $con->prepare($req);
        $stmt->execute(array(":id_pos" => $idPos));
        $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
        if (count($data) > 0) {
            $id_branche=$data[0]->id_branche;
            $branche=new Branche();
            $branche=$branche->findById($id_branche);
            $data[0]->branche=$branche;
            return $data[0];
        }
        return null;
    }

    public static function listeToken()
    {
        $con = self::connection();
        $req = "SELECT token FROM vendeur WHERE token <> NULL OR token <> '' OR token <> 'null'";
        $stmt = $con->prepare($req);
        $stmt->execute();
        $listeToken = array();
        $data = $stmt->fetchAll();
        foreach ($data as $d) {
            if (strlen($d[0]) > 15) {
                $listeToken[] = $d[0];
            }
        }
        return $listeToken;
    }

    public static function saveToken($id, $token)
    {
        $con = self::connection();
        $req = "update vendeur set token=:token where id=:id";
        $stmt = $con->prepare($req);
        if ($stmt->execute(array(":token" => $token, ":id" => $id))) {
            return "ok";
        }
        return "no";
    }

    public function getDefaultVendeur(){
        $con=self::connection();
        $req="select *from vendeur where nom='default' and prenom='vendeur'";
        $stmt=$con->prepare($req);
        $stmt->execute();
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }else{
            return null;
        }
    }


}
