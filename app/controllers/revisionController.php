<?php
namespace App\Controllers;
use App\Models\Revision;
use App\Models\Tesis;

class RevisionController{
  public function revisarTitulo($data, $files){
    $revision = new Revision();
    if($data['correccion'] == 'SI'){ // la revision se hace a una correccion del estudiante
      $revision->comentario = $data['comentario'];
      $revision->columna_tabla = 'valor';
      $revision->tabla_referencia = 'tblCorrecciones';
      $revision->id_tabla_referencia = $data['idTarget']; // idCorreccion
    }else{ // la revision se hace al titulo original
      $revision->comentario = $data['comentario'];
      $revision->columna_tabla = 'titulo';
      $revision->tabla_referencia = 'tblTesis';
      $revision->id_tabla_referencia = $data['idTarget']; // idTesis
    }
    if($revision->save() > 0){
      echo json_encode(array('status'=> true, 'message' => 'Revisión creado correctamente'));
    }else{
      echo json_encode(array('status'=> false, 'message' => 'No se pudo crear la revisión'));
    }
  }

  public function revisarObjetivo($data, $files = null){
    $revision = new Revision();
    if($data['correccion'] == 'SI'){ // la revision se hace a una correccion del estudiante
      $revision->comentario = $data['comentario'];
      $revision->columna_tabla = 'valor';
      $revision->tabla_referencia = 'tblCorrecciones';
      $revision->id_tabla_referencia = $data['idTarget']; // idCorreccion
    }else{ // la revision se hace al titulo original
      $revision->comentario = $data['comentario'];
      $revision->columna_tabla = 'objetivo';
      $revision->tabla_referencia = 'tblTesis';
      $revision->id_tabla_referencia = $data['idTarget']; //idTesis
    }
    if($revision->save() > 0){
      echo json_encode(array('status'=> true, 'message' => 'Revisión creada correctamente'));
    }else{
      echo json_encode(array('status'=> false, 'message' => 'No se pudo crear la revisión'));
    }
  }

  public function revisarEspecifico($data, $files = null){
    $revision = new Revision();
    if($data['correccion'] == 'SI'){ // la revision se hace a una correccion del estudiante
      $revision->comentario = $data['comentario'];
      $revision->columna_tabla = 'valor';
      $revision->tabla_referencia = 'tblCorrecciones';
      $revision->id_tabla_referencia = $data['idCorreccion'];
    }else{ // la revision se hace al titulo original
      $revision->comentario = $data['comentario'];
      $revision->columna_tabla = 'objetivoEspecifico';
      $revision->tabla_referencia = 'tblObjetivosEspecificos';
      $revision->id_tabla_referencia = $data['idObjetivoEspecifico'];
    }
    if($revision->save() > 0){
      echo json_encode(array('status'=> true, 'message' => 'Revisión creada correctamente'));
    }else{
      echo json_encode(array('status'=> false, 'message' => 'No se pudo crear la revisión'));
    }
  }



  public static function actualizarEstadoTesis(Tesis $tesis){
    $tesisClone = clone $tesis;
    $tesis->estado_revisado = 'SI';
    return $tesis->update($tesisClone);
  }
}


