<?php


namespace app\DefaultApp\Models;


use systeme\Model\Model;

class CodeJeux extends Model
{
    protected $table="code_jeux";
    public $id,$code,$description,$gagne;
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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getGagne()
    {
        return $this->gagne;
    }

    /**
     * @param mixed $gagne
     */
    public function setGagne($gagne): void
    {
        $this->gagne = $gagne;
    }

    public function findAll(){
        $con=self::connection();
        $req="select *from code_jeux order by id asc";
        $stmt=$con->prepare($req);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
    }

    public function findByCode($code){
        $con=self::connection();
        $req="select *from code_jeux where code=:code";
        $stmt=$con->prepare($req);
        $stmt->execute(array(":code"=>$code));
        $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
        if(count($data)>0){
            return $data[0];
        }
        return null;
    }

    public static function existe($id){
        $cj=new CodeJeux();
        $cj=$cj->findById($id);
        if($cj!==null){
            return true;
        }
        return  false;
    }


}
