<?php
if (isset($_COOKIE['user_obj'])) {
  $user = json_decode($_COOKIE['user_obj']);
  if ($user->rol != 'ADMIN') {header('Location: ../dash/');die();}
} else {
  header('Location: ../auth/login.php');
  die();
}
require_once('../app/config/database.php');
require_once('../app/models/tesis.php');
use App\Models\Tesis;
$data = Tesis::getAll('NUEVO');
// var_dump($data);

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Tesis | Lista</title>
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
          <div class="mt-4">
            <h1>Tesis</h1>
          </div>
          <div class="row" id="card-egresos">
            <div class="card shadow">
              <div class="card-header">
                <h4>
                  <i class="fa fa-table"></i> Listado 
                </h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table style="width:100%" class="table table-hover" id="tabla_tesis">
                    <thead>
                      <tr>
                        <th class="text-center">N° ID</th>
                        <th class="text-center">Título</th>
                        <th class="text-center">Objetivo</th>
                        <th class="text-center">Usuario</th>
                        <th class="text-center">Creado en</th>
                        <th class="text-center">Opciones</th>
                      </tr>
                    </thead>
                    <tbody id="t_body_envios">
                      <?php foreach ($data as $tesis): ?>
                      <tr>
                        <td><?=$tesis['idTesis']?></td>
                        <td><?=strtoupper($tesis['titulo'])?></td>
                        <td><?=$tesis['objetivo']?></td>
                        <td><?=$tesis['nombre'].' '.$tesis['apellidos']?></td>
                        <td><?=date('d/m/Y H:i',strtotime($tesis['creado_en']))?></td>
                        <td>
                          <div class="d-flex justify-content-between flex-wrap">
                            <a href="../correcciones/corregir.php?teid=<?=$tesis['idTesis']?>" class="btn btn-secondary" title="REVISAR"><i class="fa fa-solid fa-pencil"></i> REVISAR</a>
                          </div>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div><!-- fin contenedor -->

  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
  <script src="../assets/datatables/datatables.jquery.min.js"></script>
  <script src="../assets/datatables/datatables.bootstrap5.min.js"></script>

  <script src="./js/listas.js"></script>
</body>

</html>