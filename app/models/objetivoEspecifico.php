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
}