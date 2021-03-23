<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Client extends Model
{

    public $id,$nom,$prenom,$telephone,$sexe,$objet,$pseudo,$password,$connect;

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



    public function __construct($objet="client")
    {
        $this->objet=$objet;
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

    public static function existe($id){
        $cj=new Client();
        $cj=$cj->findById($id);
        if($cj!==null){
            return true;
        }
        return  false;
    }

    public static function setConnection($id)
    {
        try {
            $id_session = md5(sha1(uniqid('', true)));
            $con = self::connection();
            $req = "UPDATE client SET connect=:connect WHERE id=:id";
            $stmt = $con->prepare($req);
            if ($stmt->execute(array(
                ":connect" => "oui",
                ":id"=>$id
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

    public static function login($user_name,$password)
    {
        $password=md5($password);
        try {
            $con = self::connection();
            $req = "SELECT *FROM client WHERE pseudo=:pseudo AND password=:password";
            $stmt = $con->prepare($req);
            $stmt->execute(array(
                ":pseudo" => $user_name,
                ":password" => $password
            ));
            $data = $stmt->fetchAll(\PDO::FETCH_CLASS, __CLASS__);
            if (count($data) > 0) {
                self::setConnection($data[0]->getId());
                $data[0]->setConnect("oui");
                return $data[0];
            } else {
                return "no";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

    }

    public function getDefaultClient(){
        $con=self::connection();
        $req="select *from client where nom=:nom and prenom=:prenom";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":nom"=>"default",":prenom"=>"client"));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }else{
            return null;
        }
    }

    public function total(){
        $con=self::connection();
        $req="select *from client";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
