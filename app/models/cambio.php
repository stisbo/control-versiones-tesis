<?php
namespace App\Models;
use App\Config\Database;

class Cambio{
  public int $idCambio;
  public int $idParte;
  public string $contenido;
  public string $cambiado_en;
  public function __construct($idParte, $contenido){
    $this->idParte = $idParte;
    $this->contenido = $contenido;
  }
  public function save(){
    try {
      $sql = "INSERT INTO tblCambios (idParte, contenido) VALUES (?, ?)";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $res = $stmt->execute([$this->idParte, $this->contenido]);
      if($res){
        $this->idCambio = $con->lastInsertId();
        return true;
      }
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return false;
  }
}