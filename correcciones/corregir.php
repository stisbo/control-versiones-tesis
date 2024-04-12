<?php
if (isset($_COOKIE['user_obj'])) {
  $user = json_decode($_COOKIE['user_obj']);
} else {
  header('Location: ../auth/login.php');
  die();
}
if ($user->rol != 'ADMIN') {
  header('Location: ../');
  die();
}
if (!isset($_GET['teid'])) {
  header('Location: ../tesis/lista.php');
  die();
}
require_once('../app/config/database.php');
require_once('../app/models/revision.php');
require_once('../app/models/objetivoEspecifico.php');
require_once('../app/models/usuario.php');
require_once('../app/models/tesis.php');

use App\Models\Revision;
use App\Models\Tesis;
$idTesis = $_GET['teid'];
$dataTitulo = Revision::revisionesTituloTesis($idTesis);
$dataObjetivo = Revision::revisionesObjetivoTesis($idTesis);
$tesis = new Tesis($idTesis);
$tesis->objetivosEspecificos();

$comentarioObjEspInicial = Revision::revisionIniciarObjEsp($idTesis);

$revisionesObjEsp = [];
if($comentarioObjEspInicial != ''){// hacemos peticiones porque posiblemente tiene mas correcciones
  $revisionesObjEsp = Revision::revisionesObjEspAll($idTesis);
}
// var_dump($revisionesObjEsp);

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>TESIS | Corregir</title>
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
      <input type="hidden" id="idTesis" value="<?= $idTesis ?>">
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
                          <?php foreach ($dataTitulo as $titulo) : ?>
                            <li class="event" data-date="<?= date('d/m/y H:i', strtotime($titulo['fecha'])) ?>">
                              <h3><?= $titulo['titulo'] ?></h3>
                              <?php if ($titulo['comentario'] != null) : ?>
                                <p>- <?= $titulo['comentario'] ?></p>
                              <?php else : ?>
                                <input type="hidden" id="idTarget_titulo" value="<?=$titulo['idTarget']?>">
                                <input type="hidden" id="esCorreccion_titulo" value="<?=$titulo['tipo']?>">
                                <div class="input-group">
                                  <span class="input-group-text" style="background-color:#ebeff3"><i class="fa fa-solid fa-lg fa-comment-dots"></i></span>
                                  <textarea class="form-control" id="titulo_coment" style="height:130px;resize:none;" aria-label="With textarea" placeholder="Comentarios..."></textarea>
                                </div>
                                <button class="btn btn-sm btn-success float-end" type="button" onclick="guardarCommentTitulo()">Terminar</button>
                              <?php endif; ?>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                      <div id="content-obj-gen">
                        <ul class="timeline objetivo-gen">
                          <?php foreach ($dataObjetivo as $objetivo) : ?>
                            <li class="event" data-date="<?= date('d/m/y H:i', strtotime($objetivo['fecha'])) ?>">
                              <h3><?= $objetivo['objetivo'] ?></h3>
                              <?php if ($objetivo['comentario'] != null) : ?>
                                <p>- <?= $objetivo['comentario'] ?></p>
                              <?php else : ?>
                                <input type="hidden" id="idTarget_obj" value="<?=$objetivo['idTarget']?>">
                                <input type="hidden" id="esCorreccion_obj" value="<?=$objetivo['tipo']?>">
                                <div class="input-group">
                                  <span class="input-group-text" style="background-color:#ebeff3"><i class="fa fa-solid fa-lg fa-comment-dots"></i></span>
                                  <textarea class="form-control" id="objetivo_coment" style="height:130px;resize:none;" aria-label="With textarea" placeholder="Comentarios..."></textarea>
                                </div>
                                <button class="btn btn-sm btn-success float-end" type="button" onclick="guardarCommentObjetivo()">Terminar</button>
                              <?php endif; ?>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                      <div id="content">
                        <ul class="timeline objetivo-esp">
                          <li class="event" data-date="<?=date('d-m-y H:i',strtotime($tesis->creado_en))?>">
                            <h3>OBJETIVOS ESPECIFICOS</h3>
                            <ol>
                              <?php foreach($tesis->objetivos_especifivos as $ode): ?>
                              <li><?=$ode->objetivoEspecifico?></li>
                              <?php endforeach; ?> 
                            </ol>
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill position-absolute top-0 end-0" data-bs-toggle="popover" data-bs-title="Comentario" data-bs-content="<?=($comentarioObjEspInicial == '') ? 'Sin Comentario':$comentarioObjEspInicial ?>"><i class="fa-solid fa-comment-dots"></i></button>
                          </li>
                          <?php
                          $comentarioRevision = null;
                          $idTargetObjEsp = $idTesis;
                          $nuevo = 'SI';
                          foreach($revisionesObjEsp as $rev):
                            // var_dump($rev);
                          ?>
                          <li class="event" data-date="<?=date('d/m/y H:i', strtotime($rev['cambiado_en']))?>">
                          <h3>Cambios</h3>
                            <ol>
                              <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <?php if(isset($rev["objetivoesp".$i])): ?>
                                  <li><?= $rev["objetivoesp".$i] ?></li>
                                <?php endif;?>
                              <?php endfor; ?>
                            </ol>
                            <?php if($rev['comentario'] != null): ?>
                            <button type="button" class="btn btn-sm btn-secondary rounded-pill position-absolute top-0 end-0" data-bs-toggle="popover" data-bs-title="Comentario" data-bs-content="<?=$rev['comentario']?>"><i class="fa-solid fa-comment-dots"></i></button>
                            <?php endif; ?>
                          </li>
                          <?php 
                          $comentarioRevision = $rev['comentario'];
                          $idTargetObjEsp = $rev['idCambiosOE'];
                          $nuevo = 'NO';
                          endforeach; ?>
                          <!--<li class="event" data-date="8:30 - 9:30pm">
                            <h3>Closing Ceremony</h3>
                            <p>See how is the victor and who are the losers. The big stage is where the winners bask in their own glory.</p>
                          </li> -->
                          <?php if($comentarioRevision == null): ?>
                          <li class="event" data-date="">
                            <h3>¿Agregar comentarios?</h3>
                            <div class="input-group">
                              <span class="input-group-text" style="background-color:#ebeff3"><i class="fa fa-solid fa-lg fa-comment-dots"></i></span>
                              <textarea class="form-control" id="obj_esp_comentario" style="height:130px;resize:none;" aria-label="With textarea" placeholder="Comentarios..."></textarea>
                            </div>
                            <button class="btn btn-sm btn-success float-end" type="button" onclick="guardarCommentObjEsp(<?=$idTargetObjEsp?>,'<?=$nuevo?>')">Terminar</button>
                          </li>
                          <?php endif; ?>
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

  <script src="../assets/bootstrap/js/bootstrap.popper.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script>
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
  </script>

  <script src="./js/corregir.js"></script>
</body>

</html>