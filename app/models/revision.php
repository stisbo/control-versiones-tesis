<?php
namespace App\Models;

use App\Config\Database;
use Exception;

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
      WHERE a.idTesis = $idTesis
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
      FROM tblTesis a LEFT JOIN tblRevision b ON a.idTesis = b.id_tabla_referencia AND b.tabla_referencia = 'tblTesis' AND b.columna_tabla = 'objetivo'
      WHERE a.idTesis = $idTesis 
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
  public static function revisionIniciarObjEsp($idTesis){
    $comentario = '';
    try{
      $sql = "SELECT TOP 1 * FROM tblRevision WHERE tabla_referencia = 'tblTesis' AND columna_tabla = 'objetivoEspecifico' AND id_tabla_referencia = $idTesis;";
      $con = Database::getInstace();
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $data = $stmt->fetch();
      $comentario = $data['comentario'] ?? '';
    }catch(Exception $e){
      var_dump($e);
    }
    return $comentario;
  }
  public static function revisionesObjEspAll($idTesis){
    $data = [];
    try {
      $sql = "SELECT a.*, b.comentario FROM tblCambiosObjetivosEspecificos a
      LEFT JOIN tblRevision b ON a.idCambiosOE = b.id_tabla_referencia AND b.tabla_referencia = 'tblCambiosObjetivosEspecificos' AND a.idTesis = $idTesis WHERE a.idTesis=$idTesis;";
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