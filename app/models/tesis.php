<?php
namespace App\Models;
require_once __DIR__.'/parte.php';
use App\Config\Database;
use App\Models\Parte;

class Tesis{
  public static $sql = "SELECT * FROM tblTesis";
  public int $idTesis;
  public int $idUsuario; // owner
  public string $tipo; // TESIS | PROYECTO
  public string $creado_en;
  public $usuario = null;
  public $partes = null;

  public function __construct($idTesis = 0) {
    if ($idTesis == 0) {
      $this->objectNull();
    } else {
      $con = Database::getInstace();
      $sql = self::$sql . " WHERE idTesis = $idTesis";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch();
      if ($row) {
        $this->objectNull();
        $this->load($row);
      } else {
        $this->objectNull();
      }
    }
  }
  public function objectNull() {
    $this->idTesis = 0;
    $this->idUsuario = 0;
    $this->tipo = '';
    $this->creado_en = '';
  }
  public function load($row){
    $this->idTesis = $row['idTesis'];
    $this->idUsuario = $row['idUsuario'];
    $this->tipo = $row['tipo'];
    $this->creado_en = $row['creado_en'];
  }
  public function saveTesis($arrPartes){//Array partes
    $res = false;
    try {
      $con = Database::getInstace();
      $con->beginTransaction();
      $sql = "INSERT INTO tblTesis (idUsuario, tipo) VALUES (?, ?);";
      $stmt = $con->prepare($sql);
      $res_tesis = $stmt->execute([$this->idUsuario, $this->tipo]);
      if($res_tesis){
        $idTesis = $con->lastInsertId();
        $this->idTesis = $idTesis;
        $can = count($arrPartes);
        $success = 0;
        foreach ($arrPartes as $parte) {
          $new = new Parte(0,$idTesis,$parte['nombre'],$parte['contenido'],'REVISION');
          if($new->save()) $success++;
        }
        if($success == $can) {
          $con->commit();
          $res = true;
        }
        else $con->rollBack();
      }
    } catch (\Throwable $th) {
      var_dump($th);
      $con->rollBack();
    }
    return $res;
  }

  public function partes(){
    if($this->partes == null){
      $this->partes = Parte::getPartesByTesis($this->idTesis);
    }
    return $this->partes;
  }
  public function usuario(){
    if($this->usuario == null){
      $this->usuario = new Usuario($this->idUsuario);
    }
    return $this->usuario;
  }
  public function nombres_partes(){
    return Parte::part_names($this->idTesis);
  }
}