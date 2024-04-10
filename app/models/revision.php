<?php
namespace App\Models;

use App\Config\Database;

class Revision{
  public int $idRevision;
  public string $comentario;
  public string $tabla_referencia;
  public string $columna_tabla;
  public int $id_tabla_referencia;

  public function __construct(){
    $this->idRevision = 0;
    $this->comentario = "";
    $this->tabla_referencia = "";
    $this->columna_tabla = "";
    $this->id_tabla_referencia = 0;
  }

  public function save(){
    try {
      $sql = "INSERT INTO tblRevision(comentario, tabla_referencia, columna_tabla, id_tabla_referencia) VALUES(?,?,?,?);";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $res = $stmt->execute([$this->comentario, $this->tabla_referencia, $this->columna_tabla, $this->id_tabla_referencia]);
      if($res){
        $this->idRevision = $con->lastInsertId();
        return $this->idRevision;
      }
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return 0;
  }

  public static function revisionesTituloTesis($idTesis){
    $data = [];
    try {
      $sql = "SELECT a.idTesis as idTarget, a.titulo, b.comentario, a.creado_en as fecha, 'NO' as tipo
      FROM tblTesis a LEFT JOIN tblRevision b ON a.idTesis = b.id_tabla_referencia AND b.columna_tabla = 'titulo' AND b.tabla_referencia = 'tblTesis'
      WHERE a.idTesis = $idTesis AND b.columna_tabla = 'titulo'
      UNION
      SELECT a.idCorreccion as idTarget, a.valor as titulo, b.comentario, a.corregido_en as fecha, 'SI' as tipo
      FROM tblCorrecciones a LEFT JOIN tblRevision b ON a.idCorreccion = b.id_tabla_referencia AND b.tabla_referencia = 'tblCorrecciones' 
      WHERE a.id_tabla_referencia = $idTesis AND a.columna_tabla = 'titulo' ORDER BY fecha";

      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $data = $stmt->fetchAll(\PDO::FETCH_ASSOC); 
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return $data;
  }

  public static function revisionesObjetivoTesis($idTesis){
    $data = [];
    try {
      $sql = "SELECT a.idTesis as idTarget, a.objetivo, b.comentario, a.creado_en as fecha, 'NO' as tipo
      FROM tblTesis a LEFT JOIN tblRevision b ON a.idTesis = b.id_tabla_referencia AND b.tabla_referencia = 'tblTesis'
      WHERE a.idTesis = $idTesis AND b.columna_tabla = 'objetivo'
      UNION
      SELECT a.idCorreccion as idTarget, a.valor as objetivo, b.comentario, a.corregido_en as fecha, 'SI' as tipo
      FROM tblCorrecciones a LEFT JOIN tblRevision b ON a.idCorreccion = b.id_tabla_referencia AND b.tabla_referencia = 'tblCorrecciones' 
      WHERE a.id_tabla_referencia = $idTesis AND a.columna_tabla = 'objetivo' ORDER BY fecha";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return $data;
  }
}