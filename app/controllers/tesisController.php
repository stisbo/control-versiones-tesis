<?php

namespace App\Controllers;

use App\Models\Tesis;

class TesisController{
  public function create($data, $files){
    $response = ['status' => false];
    if(isset($_COOKIE['user_obj'])){
      $user = json_decode($_COOKIE['user_obj']);
      $tesis = new Tesis();
      $tesis->idUsuario = $user->idUsuario;
      $tesis->tipo = $data['tipo'];
      $partes = array(['nombre'=>'TÍTULO','contenido'=>$data['titulo']], ['nombre' => 'OBJETIVO GENERAL', 'contenido' => $data['objetivo']]);
      $obj_especificos = json_decode($data["o_especificos"]);
      foreach($obj_especificos as $obj_especifico){
        $partes[] = ['nombre'=>'OBJETIVO ESPECIFICO', 'contenido'=>$obj_especifico];
      }
      // mas partes
      if($tesis->saveTesis($partes)){
        $response['status'] = true;
        $response['message'] = 'Tesis creada correctamente';
      }else{
        $response['message'] = 'No se pudo crear la tesis';
      }
    }else{
      $response['message'] = 'No se encontro el usuario, sin sesion iniciada';
    }
    echo json_encode($response);
  }
  public function getDataPart($data, $files){
    
  }
}