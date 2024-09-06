<?php
namespace App\Models;

use App\Config\Database;
use App\Models\Usuario;
use App\Models\ObjetivoEspecifico;
class Tesis{
  public static string $sql = "SELECT * FROM tblTesis";
  public int $idTesis;
  public string $titulo;
  public string $objetivo;
  public string $palabrasClave;
  public int $gestion;
  public int $idUsuario;
  public Usuario $usuario;

  public string $creado_en;
  public string $estado_revisado;

  public array $objetivos_especifivos = [];
  public string $problema;
  public string $formulacion_problema;
  public string $limites;
  public string $tipo;

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
    $this->titulo = "";
    $this->objetivo = "";
    $this->palabrasClave = "";
    $this->gestion = 0;
    $this->idUsuario = 0;
    $this->usuario = new Usuario();
    $this->creado_en = '';
    $this->estado_revisado = '';
    $this->problema = '';
    $this->formulacion_problema = '';
    $this->limites = '';
    $this->tipo = '';
  }

  public function load($row){
    $this->idTesis = $row['idTesis'];
    $this->titulo = $row['titulo'];
    $this->objetivo = $row['objetivo'];
    $this->palabrasClave = $row['palabrasClave'];
    $this->gestion = $row['gestion'];
    $this->idUsuario = $row['idUsuario'];
    $this->creado_en = $row['creado_en'];
    $this->estado_revisado = $row['estado_revisado'];
    $this->usuario = new Usuario($this->idUsuario);
    $this->problema = $row['problema'] ?? '';
    $this->formulacion_problema = $row['formulacion_problema'] ?? '';
    $this->limites = $row['limites'] ?? '';
    $this->tipo = $row['tipo'] ?? '';
  }

  public function update($anterior) {
    try {
      $cadena = "";
      $params = [];
      foreach ($this as $name => $value) {
        if ($this->$name != $anterior->$name) {
          $cadena .= "$name = :$name, ";
          $params[$name] = $this->$name;
        }
      }
      if ($cadena != "") {
        $cadena = substr($cadena, 0, -2);
        $sql = "UPDATE tblTesis SET $cadena WHERE idTesis = :idTesis";
        $con = Database::getInstace();
        $stmt = $con->prepare($sql);
        $params['idTesis'] = $this->idTesis;
        $res = $stmt->execute($params);
        return $res;
      }
    } catch (\Throwable $th) {
      print_r($th);
    }
    return false;
  }

  public function insert(){
    try {
      $sql = "INSERT INTO tblTesis (titulo, objetivo, palabrasClave, gestion, idUsuario, problema,formulacion_problema, limites, tipo) VALUES (:titulo, :objetivo, :palabrasClave, :gestion, :idUsuario, :problema, :formulacion, :limites, :tipo);";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $params = [
        'titulo' => $this->titulo,
        'objetivo' => $this->objetivo,
        'palabrasClave' => $this->palabrasClave,
        'gestion' => $this->gestion,
        'idUsuario' => $this->idUsuario,
        'problema' => $this->problema,
        'formulacion' => $this->formulacion_problema,
        'limites' => $this->limites,
        'tipo' => $this->tipo,
      ];
      $res = $stmt->execute($params);
      if ($res) {
        $this->idTesis = $con->lastInsertId();
        return $this->idTesis;
      }
    } catch (\Throwable $th) {
      print_r($th);
    }
    return 0;
  }

  public function delete(){
    try {
      $sql = "DELETE FROM tblTesis WHERE idTesis = :idTesis";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $res = $stmt->execute(['idTesis' => $this->idTesis]);
      return $res;
    } catch (\Throwable $th) {
      //throw $th;
    }
    return 0;
  }

  public static function usuario($idUsuario){
    $tesis = new Tesis();
    try {
      $sql = "SELECT * FROM tblTesis WHERE idUsuario = $idUsuario";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $row = $stmt->fetch();
      if ($row) 
        $tesis->load($row);
    } catch (\Throwable $th) {
      //throw $th;
    }
    return $tesis;
  }
  public function objetivosEspecificos(){
    $objetivos = [];
    try {
      $objetivos = ObjetivoEspecifico::getByIdTesis($this->idTesis);
    } catch (\Throwable $th) {
      var_dump($th);
    }
    $this->objetivos_especifivos = $objetivos;
  }

  public static function getAll($estado = ''){ // sin formato
    $tesis = [];
    try {
      if($estado == 'NUEVO'){
        $sql = "SELECT a.*, b.nombre, b.apellidos FROM tblTesis a INNER JOIN tblUsuario b ON a.idUsuario = b.idUsuario WHERE a.estado_revisado = 'NO' ORDER BY a.idTesis DESC;";
      }else{
        $sql = "SELECT a.*, b.nombre, b.apellidos FROM tblTesis a INNER JOIN tblUsuario b ON a.idUsuario = b.idUsuario ORDER BY a.idTesis DESC;";
      }
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $tesis = $stmt->fetchAll();
    } catch (\Throwable $th) {
      //throw $th;
    }
    return $tesis;
  }
  public static function revisado_update($idTesis){
    try {
      $con = Database::getInstace();
      $sql = "UPDATE tblTesis SET estado_revisado = 'SI' WHERE idTesis = $idTesis";
      $stmt = $con->prepare($sql);
      return $stmt->execute();
    } catch (\Throwable $th) {
      //throw $th;
    }
    return false;
  }

}