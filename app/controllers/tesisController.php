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
}