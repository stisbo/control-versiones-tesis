<?php
namespace App\Models;
use App\Config\Database;

class Parte{
  public int $idParte;
  public int $idTesis;
  public string $nombre;
  public string $contenido;
  public string $comentarioInicial;
  public string $estado; // REVISION | ACEPTADO | CORRECCION
  public string $fechaComentado;
  public function __construct($idParte=0, $idTesis = 0, $nombre = '', $contenido ='', $estado=''){
    $this->idParte = $idParte;
    $this->idParte = 0;
    $this->idTesis = $idTesis;
    $this->nombre = $nombre;
    $this->contenido = $contenido;
    $this->estado = $estado;
    $this->fechaComentado = '';
  }
  public function save(){
    try {
      $sql = "INSERT INTO tblPartes(idTesis, nombre, contenido, estado) VALUES(?, ?, ?, ?);";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $res = $stmt->execute([$this->idTesis, strtoupper($this->nombre), $this->contenido, $this->estado]);
      $this->idParte = $con->lastInsertId();
      return $this->idParte;
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return 0;
  }
  public function updateState(){
    try {
      $sql = "UPDATE tblPartes SET estado = ? WHERE idParte = ?";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $res = $stmt->execute([$this->estado, $this->idParte]);
      return $res;
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return false;
  }
  public function comentarioInicial(){
    try {
      $sql = "UPDATE tblPartes SET comentarioInicial = ?, fechaComentado = ? WHERE idParte = ?";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $res = $stmt->execute([$this->comentarioInicial, $this->fechaComentado, $this->idParte]);
      return $res;
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return false;
  }

  public static function getPartesByTesis($idTesis){
    try {
      $sql = "SELECT * FROM tblPartes WHERE idTesis = ?";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $stmt->execute([$idTesis]);
      $res = $stmt->fetchAll();
      return $res;
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return [];
  }
  public static function part_names($idTesis){
    try {
      $sql = "SELECT distinct nombre FROM tblPartes WHERE idTesis = ?";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $stmt->execute([$idTesis]);
      $res = $stmt->fetchAll();
      return $res;
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return [];
  }
}