<?php
if (isset($_COOKIE['user_obj'])) {
  header('Location: ../');
  die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Registro </title>
  <link href="../css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/jquery/jqueryToast.min.css">
  <script src="../assets/jquery/jquery.js"></script>
  <script src="../assets/jquery/jqueryToast.min.js"></script>
  <script src="../assets/fontawesome/fontawesome6.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Crear Cuenta</h3>
                </div>
                <div class="card-body">
                  <div id="messages"></div>
                  <form id="form_register">
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="email" type="email" placeholder="Ingresa tu correo" name="usuario" />
                          <label for="email">Correo electrónico</label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="nombre" type="text" placeholder="Ingresa tu nombre" name="name" max="70"/>
                          <label for="nombre">Nombre (s) </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="apellido" type="text" placeholder="Ingresa tu apellidos" name="lastname" max="80"/>
                          <label for="apellido">Apellidos</label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="inputPassword" type="password" placeholder="Crea contraseña" name="password" />
                          <label for="inputPassword">Contraseña</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="inputPasswordConfirm" type="password" name="password2" placeholder="Confirmar Contraseña" />
                          <label for="inputPasswordConfirm">Confirma contraseña</label>
                        </div>
                      </div>
                    </div>
                    <div class="mt-4 mb-0">
                      <div class="d-grid"><button type="sumbit" class="btn btn-primary btn-block" >Crear Cuenta</button></div>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small">¿Ya tienes cuenta? <a href="login.php">Ingresar</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="../js/scripts.js"></script>
  <script>
    $(document).on('submit', '#form_register', async (e) => {
      e.preventDefault();
      const data = $("#form_register").serialize();
      console.log(data)
      const res = await $.ajax({
        url: '../app/usuario/create',
        type: 'POST',
        data,
        dataType: 'json',
      })
      if (res.status == 'success') {
        $.toast({
          heading: 'Registro exitoso',
          text: 'Redireccionando a la pagina principal',
          showHideTransition: 'slide',
          icon: 'success'
        });
        setTimeout(() => {
          window.location.href = '../';
        }, 1300)
      } else {
        $('#messages').html(`<div class="alert alert-danger">${res.message}</div>`)
      }
    })
    $('#form_register').on('input', () => {
      $("#messages").html('')
    })
    $("#inputPasswordConfirm").on('input', () => {
      const password = $("#inputPassword").val()
      const passwordConfirm = $("#inputPasswordConfirm").val()
      if (password === passwordConfirm) {
        $("#inputPasswordConfirm").removeClass("is-invalid")
        $("#inputPasswordConfirm").addClass("is-valid")
      } else {
        $("#inputPasswordConfirm").removeClass("is-valid")
        $("#inputPasswordConfirm").addClass("is-invalid")
      }
    })
  </script>
</body>

</html>