<?php

namespace app\DefaultApp\Models;

use systeme\Model\Model;

class PosPrimeTirage extends Model
{
  protected $table="pos_prime_tirage";
  public $id,$id_pos,$tirage,$prime,$id_entreprise;

  public static function rechercherParPosTirage($id_pos,$tirage){
      $con=self::connection();
      $req="select *from pos_prime_tirage where id_pos=:id_pos and tirage=:tirage";
      $stmt=$con->prepare($req);
      $stmt->execute(array(":id_pos"=>$id_pos,":tirage"=>$tirage));
      $data=$stmt->fetchAll(\PDO::FETCH_CLASS,__CLASS__);
      if(count($data)>0){
          return $data[0];
      }
      return null;
  }
}
