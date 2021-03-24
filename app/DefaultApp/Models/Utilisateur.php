<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class Utilisateur extends Model
{

    public $id,$nom,$prenom,$pseudo,$password,$role,$objet,$connect;

    /**
     * @return mixed|string
     */
    public function getConnect()
    {
        return $this->connect;
    }

    /**
     * @param mixed|string $connect
     */
    public function setConnect($connect)
    {
        $this->connect = $connect;
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
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * @param mixed $objet
     */
    public function setObjet($objet): void
    {
        $this->objet = $objet;
    }

    public function __construct($objet="utilisateur",$connect="non")
    {
        $this->objet=$objet;
        $this->connect=$connect;
    }

    public static function setConnection($id)
    {
        try {
            $id_session = md5(sha1(uniqid('', true)));
            $con = self::connection();
            $req = "UPDATE utilisateur SET connect=:connect WHERE id=:id";
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
            $req = "SELECT *FROM utilisateur WHERE pseudo=:pseudo AND password=:password";
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

    public function total(){
        $con=self::connection();
        $req="select *from utilisateur";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function listeSuperviseur(){
        $con=self::connection();
        $req="select *from utilisateur where role='superviseur' order by id desc";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }
}
