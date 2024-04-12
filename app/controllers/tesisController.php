<?php

namespace App\Controllers;

use App\Models\Tesis;
use App\Models\ObjetivoEspecifico;

class TesisController{
  public function create($data, $files){
    $response = ['status' => false];
    if(isset($_COOKIE['user_obj'])){
      $user = json_decode($_COOKIE['user_obj']);
      $tesis = new Tesis();
      $tesis->gestion = date('Y');
      $tesis->titulo = $data['titulo'];
      $tesis->objetivo = $data['objetivo'];
      $tesis->palabrasClave = $data['palabrasClave'] ?? '';
      $tesis->idUsuario = $user->idUsuario;
      if($tesis->insert() > 0){
        $obj_especificos = json_decode($data["o_especificos"]);
        $c = 0;
        $total = 0;
        foreach($obj_especificos as $obj_especifico){
          $total++;
          $obj = new ObjetivoEspecifico();
          $obj->idTesis = $tesis->idTesis;
          $obj->objetivoEspecifico = $obj_especifico;
          if($obj->create() > 0) $c++;
        }
        if($c == $total){
          $tesis->objetivos_especifivos = ObjetivoEspecifico::getByIdTesis($tesis->idTesis);
          $response['status'] = true;
          $response['message'] = 'Tesis creada correctamente';
          $response['tesis'] = $tesis;
        }else{
          $response['message']='Ocurrio un error al crear los objetivos de la tesis';
        }
      }else{
        $response['message']='Ocurrio un error al crear la tesis';
      }
    }else{
      $response['message'] = 'No se encontro el usuario, sin sesion iniciada';
    }
    echo json_encode($response);
  }
  public function cargar_obj_esp($data, $files){
    $valores = ObjetivoEspecifico::obtenerUltimaVersion($data['idTesis']);
    $html = '<form id="form_edit_obj_esp"><input type="hidden" name="idTesis" id="id_tesis_objetivos" value="'.$data['idTesis'].'">
    <input type="hidden" value="'.count($valores).'" id="cantidad_objetivos">';
    $i = 0;
    foreach($valores as $obj){
      $i++;
      $html .= '<div class="from-group mt-3">
        <label>Objetivo específico '.$i.'</label>
        <textarea class="form-control" name="obj_esp[]" style="height:110px;resize:none;">'.$obj.'</textarea>
      </div>';
    }
    if($i < 5){
      $html .= '<div id="contenedor_nuevos"></div><button class="btn btn-success mt-2" type="button" onclick="agregarNuevoObjEsp()" >Agregar otro Objetivo</button>';
    }
    echo $html.'</form>';
  }
}