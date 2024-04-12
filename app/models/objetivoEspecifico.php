<?php
namespace App\Models;
use App\Config\Database;
class ObjetivoEspecifico{
  public string $objetivoEspecifico;
  public int $idObjetivoEspecifico;
  public int $idTesis;

  public function __construct(){}
  public function create(){
    try {
      $con = Database::getInstace();
      $sql = "INSERT INTO tblObjetivosEspecificos (objetivoEspecifico, idTesis) VALUES (?,?)";
      $stmt = $con->prepare($sql);
      $stmt->execute([$this->objetivoEspecifico, $this->idTesis]);
      return $con->lastInsertId();
    } catch (\Throwable $th) {
      print_r($th);
    }
    return 0;
  }
  public function load($data){
    $this->objetivoEspecifico = $data['objetivoEspecifico'];
    $this->idTesis = $data['idTesis'];
    $this->idObjetivoEspecifico = $data['idObjetivoEspecifico'];
  }

  public static function getByIdTesis($idTesis){
    $res = [];
    try {
      $con = Database::getInstace();
      $sql = "SELECT * FROM tblObjetivosEspecificos WHERE idTesis = ?";
      $stmt = $con->prepare($sql);
      $stmt->execute([$idTesis]);
      foreach ($stmt->fetchAll() as $row) {
        $obj = new ObjetivoEspecifico();
        $obj->load($row);
        $res[] = $obj;
      }
    } catch (\Throwable $th) {
      //throw $th;
    }
    return $res;
  }

  public static function obtenerUltimaVersion($idTesis){
    $data = [];
    try {
      $con = Database::getInstace();
      $sql = "SELECT TOP 1 * FROM tblCambiosObjetivosEspecificos WHERE idTesis = $idTesis ORDER BY cambiado_en DESC;";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $rows = $stmt->fetch();
      if($rows){
        for ($i=1; $i <= 5; $i++) { 
          if(isset($rows["objetivoesp$i"])){
            $data[] = $rows["objetivoesp$i"];
          }
        }
      }else{
        $sql2 = "SELECT * FROM tblObjetivosEspecificos WHERE idTesis = $idTesis";
        $stmt2 = $con->prepare($sql2);
        $stmt2->execute();
        $i = 1;
        foreach ($stmt2->fetchAll() as $obj) {
          $data['objetivoesp'.$i] = $obj['objetivoEspecifico'];
          $i++;
        }
      }
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return $data;
  }
  public static function corregirObjetivoEspecifico($objetivos, $idTesis):bool{
    try {
      $con = Database::getInstace();
      $i = 1;
      $cadVals = '';
      $cadNames = '';
      foreach($objetivos as $objetivo){
        $cadVals .= "'$objetivo',";
        $cadNames .= "objetivoesp$i,";
        $i++;
      }
      $cadVals = rtrim($cadVals,',');
      $cadNames = rtrim($cadNames,',');
      $sql = "INSERT INTO tblCambiosObjetivosEspecificos(idTesis, $cadNames) VALUES($idTesis, $cadVals);";
      $stmt = $con->prepare($sql);
      return $stmt->execute();
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return false;
  }
}

// 5 7 10 15