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
if($tesis->idTesis != 0){
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
            <form id="form_nuevo">
              <input type="hidden" name="id_usuario_envio" value="<?= $user->idUsuario ?>">
              <div class="card shadow">
                <div class="card-body">
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
                      <button class="btn btn-primary rounded-pill" type="button" id="btn_add_obj">Agregar objetivo  <span class="badge bg-secondary" id="cant_obj_especificos">0</span></button>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row mt-2" id="pila_objetivos"></div>
                  <div class="card-footer">
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-success shadow" id="btn_submit_form">GUARDAR</button>
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

  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script src="../assets/datatables/datatables.bootstrap5.min.js"></script>
  <script src="./js/nuevo.js"></script>
</body>

</html>