<?php
namespace App\Controllers;
use App\Models\Correccion;
use App\Models\Tesis;
use App\Models\ObjetivoEspecifico;
class CorreccionController{
  public function corregirTitulo($data, $files){
    $correccion = new Correccion();
    if(isset($data['idTesis'])){
      $correccion->comentario = $data['comentario'] ?? '';
      $correccion->columna_tabla = 'titulo';
      $correccion->tabla_referencia = 'tblTesis';
      $correccion->id_tabla_referencia = $data['idTesis']; 
      $correccion->valor = $data['valor'];
      if($correccion->save() > 0){
        // $tesis = new Tesis($data['idTesis']);
        // $tesisClone = clone $tesis;
        // $tesis->estado_revisado = 'NO';
          echo json_encode(array('status'=> true, 'message' => 'Corrección realizada'));
        // if($tesis->update($tesisClone)){
        // }else{
        //   echo json_encode(array('status' => true, 'message' => 'Ocurrio un error en la actualizacion de la tesis'));
        // }
      }else{
        echo json_encode(array('status'=> false, 'message' => 'Ocurrio un error en la guardar la corrección'));
      }
    }else{
      echo json_encode(array('status'=> false, 'message' => 'Id de la tesis necesaria'));
    }
  }
  public function corregirObjetivo($data, $files){
    $correccion = new Correccion();
    if(isset($data['idTesis'])){
      $correccion->comentario = $data['comentario'] ?? '';
      $correccion->columna_tabla = 'objetivo';
      $correccion->tabla_referencia = 'tblTesis';
      $correccion->id_tabla_referencia = $data['idTesis']; 
      $correccion->valor = $data['valor'];
      if($correccion->save() > 0){
        echo json_encode(array('status'=> true, 'message' => 'Corrección realizada'));
      }else{
        echo json_encode(array('status'=> false, 'message' => 'Ocurrio un error en la guardar la corrección'));
      }
    }else{
      echo json_encode(array('status'=> false, 'message' => 'Id de la tesis necesaria'));
    }
  }

  public function corregir_obj_esp($data, $files = null){
    $objetivos = [];
    if(isset($data['obj_esp_nuevo'])){
      foreach ($data['obj_esp_nuevo'] as $texto) {
        $objetivos[] = $texto;
      }
      foreach ($data['obj_esp'] as $txt_obj) {
        $objetivos[] = $txt_obj;
      }
      
    }else{
      foreach ($data['obj_esp'] as $txt_obj) {
        $objetivos[] = $txt_obj;
      }
    }
    if(ObjetivoEspecifico::corregirObjetivoEspecifico($objetivos, $data['idTesis'])){
      echo json_encode(['status'=>true, 'message'=>'Datos de objetivos esp. agregados con exito']);
    }else{
      echo json_encode(['status' => false, 'message' => 'Ocurrio un error al guardar los datos']);
    }
  }
}