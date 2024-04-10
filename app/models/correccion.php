<?php
namespace App\Models;
use App\Config\Database;

class Correccion {
  public int $idCorreccion;
  public string $valor;
  public string $tabla_referencia;
  public string $columna_tabla;
  public int $id_tabla_referencia;
  public string $comentario;
  public string $corregido_en;
  public $titulo = [];
  public $objetivo = [];
  public function __construct() {
    $this->idCorreccion = 0;
    $this->comentario = "";
    $this->tabla_referencia = "";
    $this->columna_tabla = "";
    $this->id_tabla_referencia = 0;
    $this->valor = "";
    $this->corregido_en = "";
  }

  public function save(){
    try {
      $sql = "INSERT INTO tblCorrecciones(tabla_referencia,columna_tabla,valor,id_tabla_referencia, comentario) VALUES(?, ?, ?, ?, ?);";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $res = $stmt->execute([$this->tabla_referencia, $this->columna_tabla, $this->valor, $this->id_tabla_referencia, $this->comentario]);
      if($res){
        $this->idCorreccion = $con->lastInsertId();
        return $this->idCorreccion;
      }
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return 0;
  }

  // public static function adf(){

  // }
}