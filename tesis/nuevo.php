<?php
if (isset($_COOKIE['user_obj'])) {
  $user = json_decode($_COOKIE['user_obj']);
} else {
  header('Location: ../auth/login.php');
  die();
}
require_once('../app/config/database.php');
require_once('../app/models/tesis.php');
require_once('../app/models/usuario.php');

use App\Models\Tesis;

$tesis = Tesis::usuario($user->idUsuario);
if ($tesis->idTesis != 0) {
  header('Location: ../tesis/ver.php');
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>TESIS | Crear</title>
  <link rel="stylesheet" href="../assets/datatables/datatables.bootstrap5.min.css">
  <link href="../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/jquery/jqueryToast.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <link rel="stylesheet" href="./css/nuevo.css">
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
        <div class="container-fluid px-4">
          <h1 class="mt-4">TESIS - PROYECTO</h1>
          <div class="buttons-head col-md-6 col-sm-12 mb-3">
            <button type="button" id="btn_volver_page" class="btn btn-secondary" onclick="history.back()"><i class="fa fa-arrow-left"></i> Volver </button>
          </div>
          <div class="row" id="card-egresos">
            <form id="form_nuevo" onsubmit="return false;">
              <input type="hidden" name="id_usuario_envio" value="<?= $user->idUsuario ?>">
              <div class="card shadow">
                <div class="card-body">
                  <div class="fx-block d-flex justify-content-center">
                    <div class="toggle">
                      <div>
                        <input type="checkbox" id="toggles">
                        <div data-unchecked="TESIS" data-checked="PROYECTO"></div>
                      </div>
                    </div>
                  </div>
                  <ul class="nav nav-tabs d-flex justify-content-center fw-bold" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Titulo | Objetivos | Problema</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Limites | Alcances | Justificación</button>
                    </li>
                  </ul>
                  <div class="tab-content mt-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                      <div class="row">
                        <div class="col-md-6">
                          <p class="fs-4 fw-bold"><i class="fa fa-solid fa-file"></i> Escribe el título</p>
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Titulo" name="titulo" rows="4" style="height:135px;resize:none;"></textarea>
                            <label for="">Título</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <p class="fs-4 fw-bold"><i class="fa fa-solid fa-file"></i> Objetivo general</p>
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Objetivo central" name="objetivo" rows="4" style="height:135px;resize:none;"></textarea>
                            <label for="">Objetivo General</label>
                          </div>
                        </div>
                        <p class="fs-4 fw-bold"><i class="fa-solid fa-diagram-project"></i> Objetivos específicos</p>
                        <div class="col-md-6">
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" id="obj_esp" placeholder="Objetivo especifico" rows="4" style="height:145px;resize:none;"></textarea>
                            <label for="">Objetivo específico</label>
                          </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                          <button class="btn btn-primary rounded-pill" type="button" id="btn_add_obj">Agregar objetivo <span class="badge bg-secondary" id="cant_obj_especificos">0</span></button>
                        </div>
                      </div>
                      <div class="divider"></div>
                      <div class="row mt-2" id="pila_objetivos"></div>

                      <div class="row">
                        <div class="col-md-6">
                          <p class="fs-4 fw-bold"><i class="fa-solid fa-folder-tree"></i> Plantemiento de problema</p>
                          <p class="text-muted mb-0">Declarativa / Interrogativa</p>
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Problema" name="formulacion" rows="4" style="height:135px;resize:none;"></textarea>
                            <label for="">Formulación del problema</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <p class="fs-4 fw-bold"><i class="fa-solid fa-file-zipper"></i> Problema</p>
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Problema" name="problema" rows="4" style="height:135px;resize:none;"></textarea>
                            <label for="">Problema</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="tab-pane fade " id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                      <div class="row">
                        <div class="col-md-8">
                          <p class="fs-4 fw-bold"><i class="fa-solid fa-medal"></i> Límites</p>
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Limites" name="limite" rows="4" style="height:135px;resize:none;"></textarea>
                            <label for="">Límites</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <p class="fs-4 fw-bold"><i class="fa-brands fa-leanpub"></i> Justificación</p>
                        <div class="col-md-3">
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Justificacion" name="j_tecnica" rows="8" style="height:175px;resize:none;"></textarea>
                            <label for="">Técnica</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Justificacion" name="j_economica" rows="8" style="height:175px;resize:none;"></textarea>
                            <label for="">Económica</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Justificacion" name="j_social" rows="8" style="height:175px;resize:none;"></textarea>
                            <label for="">Social</label>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-floating mb-3 d-none" id="j_ciencia">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Justificacion" name="j_cientifico" rows="8" style="height:175px;resize:none;"></textarea>
                            <label for="">Científica</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <p class="fs-4 fw-bold"><i class="fa-solid fa-arrows-to-eye"></i> Alcances</p>
                        <div class="col-md-4">
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Alcances" name="a_tematica" rows="8" style="height:175px;resize:none;"></textarea>
                            <label for="">Temática</label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Alcances" name="a_geografico" rows="8" style="height:175px;resize:none;"></textarea>
                            <label for="">Geográfico</label>
                            <button type="button" class="btn btn-sm btn-primary position-absolute bottom-0 end-0" data-bs-toggle="modal" data-bs-target="#modal_imagen"><i class="fa fa-solid fa-plus"></i><i class="fa fa-solid fa-image"></i></button>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-floating mb-3">
                            <textarea class="form-control validate[required,maxSize[250]]" placeholder="Alcances" name="a_temporal" rows="8" style="height:175px;resize:none;"></textarea>
                            <label for="">Temporal</label>
                          </div>
                        </div>
                      </div>

                      <div class="row my-3">
                        <div class="d-flex justify-content-center">
                          <button type="submit" class="btn btn-success shadow" id="btn_submit_form">GUARDAR</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- end card -->
            </form>
          </div>
        </div>
      </main>
    </div>
  </div><!-- fin contenedor -->

  <!-- Modal imagen -->
  <div class="modal fade" id="modal_imagen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h1 class="modal-title fs-5"><i class="fa fa-solid fa-image"></i> Agregar imagen</h1>
        </div>
        <div class="modal-body">
          <div class="m-3">
            <label for="formFile" class="form-label">Imágen de alcance geográfico</label>
            <input class="form-control" type="file" id="file_geografico" accept="image/jpeg, image/jpg, image/png">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="imagen = false;">Cancelar</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="imagen = true">Agregar</button>
        </div>
      </div>
    </div>
  </div>


  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script src="../assets/datatables/datatables.bootstrap5.min.js"></script>
  <script src="./js/nuevo.js"></script>
</body>

</html>