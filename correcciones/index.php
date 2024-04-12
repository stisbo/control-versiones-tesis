<?php
if (isset($_COOKIE['user_obj'])) {
  $user = json_decode($_COOKIE['user_obj']);
} else {
  header('Location: ../auth/login.php');
  die();
}
require_once('../app/models/revision.php');
require_once('../app/config/database.php');
require_once('../app/models/objetivoEspecifico.php');
require_once('../app/models/tesis.php');
require_once('../app/models/usuario.php');

use App\Models\Tesis;
use App\Models\Revision;

$tesis = Tesis::usuario($user->idUsuario);

$dataTitulo = Revision::revisionesTituloTesis($tesis->idTesis);
$dataObjetivo = Revision::revisionesObjetivoTesis($tesis->idTesis);
// var_dump($dataTitulo);
// echo '<hr>';
// var_dump($dataObjetivo);
$tituloCorregir = '';
$objetivoCorregir = '';

$comentarioObjEspInicial = Revision::revisionIniciarObjEsp($tesis->idTesis);
// var_dump($comentarioObjEspInicial);
$revisionesObjEsp = [];
if ($comentarioObjEspInicial != '') { // hacemos peticiones porque posiblemente tiene mas correcciones
  $revisionesObjEsp = Revision::revisionesObjEspAll($tesis->idTesis);
}
$tesis->objetivosEspecificos();
// var_dump($revisionesObjEsp);
// var_dump($comentarioObjEspInicial);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>TESIS | Ver</title>
  <link rel="stylesheet" href="../assets/datatables/datatables.bootstrap5.min.css">
  <link href="../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/jquery/jqueryToast.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <link rel="stylesheet" href="./css/index.css">
  <script src="../assets/fontawesome/fontawesome6.min.js"></script>
  <script src="../assets/jquery/jquery.js"></script>
  <script src="../assets/jquery/jqueryToast.min.js"></script>
</head>

<body>
  <?php include("../common/header.php"); ?>
  <div id="layoutSidenav"> <!-- contenedor -->
    <?php include("../common/sidebar.php"); ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="card shadow">
                <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">TÍTULO</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">OBJETIVO GENERAL</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">OBJETIVOS ESPECÍFICOS</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                      <div id="content">
                        <ul class="timeline title-p">
                          <?php
                          $existeComentario_title = null;
                          foreach ($dataTitulo as $titulo) : ?>
                            <li class="event" data-date="<?= date('d/m/y H:i', strtotime($titulo['fecha'])) ?>">
                              <h3><?= $titulo['titulo'] ?></h3>
                              <p>Comentario: <?= ($titulo['comentario'] == null) ? 'Sin comentario aún' : $titulo['comentario'] ?></p>
                            </li>
                          <?php
                            $existeComentario_title = $titulo['comentario'];
                            $tituloCorregir = $titulo['titulo'] ?? '';
                          endforeach;
                          ?>
                          <?php if ($existeComentario_title != null) : ?>
                            <li class="event" data-date="Hora Actual">
                              <h3>¿Modificar título?</h3>
                              <div class="form-group">
                                <textarea class="form-control" placeholder="Nuevo titulo" id="correccion_titulo" style="height: 110px;resize:none;"><?= $tituloCorregir ?></textarea>
                                <!-- <label for="correccion_titulo">Título</label> -->
                              </div>
                              <button class="btn btn-sm btn-success float-end" onclick="corregirTitulo(<?= $tesis->idTesis ?>)" type="button">Corregir</button>
                            </li>
                          <?php endif; ?>
                        </ul>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                      <div id="content-obj-gen">
                        <ul class="timeline objetivo-gen">
                          <?php
                          $existeComentario = null;
                          foreach ($dataObjetivo as $objetivo) : ?>
                            <li class="event" data-date="<?= date('d/m/y H:i', strtotime($objetivo['fecha'])) ?>">
                              <h3><?= $objetivo['objetivo'] ?></h3>
                              <p>Comentario: <?= ($objetivo['comentario'] == null) ? 'Sin comentario' : $objetivo['comentario'] ?></p>
                            </li>
                          <?php
                            $existeComentario = $objetivo['comentario'];
                            $objetivoCorregir = $objetivo['objetivo'] ?? '';
                          endforeach;
                          ?>
                          <?php if ($existeComentario != null) : ?>
                            <li class="event" data-date="Hora actual">
                              <h3>¿Corregir Objetivo general?</h3>
                              <div class="form-group">
                                <textarea class="form-control" placeholder="Corregir objetivo" id="correccion_objetivo" style="height: 110px;resize:none;"><?= $objetivoCorregir ?></textarea>
                                <!-- <label for="correccion_objetivo">Objetivo general</label> -->
                              </div>
                              <button class="btn btn-sm btn-success float-end" onclick="corregirObjetivo(<?= $tesis->idTesis ?>)" type="button">Corregir</button>
                            </li>
                          <?php endif; ?>
                        </ul>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                      <div id="content">
                        <ul class="timeline objetivo-esp">
                          <li class="event" data-date="<?=date('d/m/y H:i',strtotime($tesis->creado_en))?>">
                            <h3>OBJETIVOS ESPECIFICOS</h3>
                            <ol>
                              <?php foreach ($tesis->objetivos_especifivos as $ode) : ?>
                                <li><?= $ode->objetivoEspecifico ?></li>
                              <?php endforeach; ?>
                            </ol>
                            <?php if(count($revisionesObjEsp) == 0): ?>
                              <button type="button" class="btn btn-primary btn-sm rounded-pill position-absolute top-0 end-0" data-bs-toggle="modal" data-id="<?=$tesis->idTesis?>" data-bs-target="#modal_editar_objetivos" <?=($comentarioObjEspInicial == '')?'disabled':''?>><i class="fa fa-solid fa-pencil"></i></button>
                            <?php endif; ?>
                            <div class="alert alert-warning mt-2"><b>Comentario:</b> <?=$comentarioObjEspInicial?></div>
                          </li>
                          <?php
                          $ultimoElemento = count($revisionesObjEsp);
                          $mostrados = 1;                       
                          foreach($revisionesObjEsp as $res) : ?>
                          <li class="event" data-date="<?=date('d/m/y H:i', strtotime($res['cambiado_en']))?>">
                            <h3>Cambios</h3>
                            <ol>
                              <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <?php if(isset($res["objetivoesp".$i])): ?>
                                  <li><?= $res["objetivoesp".$i] ?></li>
                                <?php endif;?>
                              <?php endfor; ?>
                            </ol>
                            <?php if($ultimoElemento == $mostrados): ?>
                              <button type="button" class="btn btn-primary btn-sm rounded-pill position-absolute top-0 end-0" data-bs-toggle="modal" data-id="<?=$tesis->idTesis?>" data-bs-target="#modal_editar_objetivos" <?=$res['comentario'] == null ? 'disabled' : '' ?>><i class="fa fa-solid fa-pencil"></i></button>
                            <?php endif; ?>
                            <div class="alert alert-warning mt-2"><b>Comentario:</b> <?=$res['comentario'] == null ? 'Sin comentar': $res['comentario']?></div>
                          </li>
                          <?php 
                          $mostrados++;
                          endforeach; ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div><!-- fin contenedor -->
  <?php include('./modalObjetivos.php') ?>
  <script src="../assets/bootstrap/js/bootstrap.popper.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script>
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
  </script>
  <script src="./js/app.js"></script>
</body>

</html>