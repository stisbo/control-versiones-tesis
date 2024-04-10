<?php
$onlyModels = ['objetivoEspecifico'];
foreach ($onlyModels as $model) {
  require_once("models/" . $model . ".php");
}
$entidades = ['usuario', 'tesis', 'revision', 'correccion'];
foreach ($entidades as $entidad) {
  require_once("models/" . $entidad . ".php");
  require_once("controllers/" . $entidad . "Controller.php");
}
