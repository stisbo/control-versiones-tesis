<?php

namespace App\Controllers;

use App\Models\Usuario;

class UsuarioController {
  public function create($data, $files) {
    $usuario = new Usuario();
    if(Usuario::userExist($data['usuario'])){
      echo json_encode(array('status' => 'error', 'message' => 'El usuario ya existe. <a href="./login.php">Ingresar</a>'));
      return;
    }else if($data['password'] != $data['password2']){
      echo json_encode(array('status' => 'error', 'message' => 'Las contraseñas no coinciden'));
      return;
    }
    $usuario->usuario = $data['usuario'];
    $usuario->password = hash('sha256', $data['usuario']);
    $usuario->nombre = $data['name'];
    $usuario->apellidos = $data['lastname'];
    $usuario->rol = 'USER';
    $res = $usuario->save();
    if ($res) {
      setcookie('user_obj', json_encode($usuario), time() + 64800, '/', false);
      echo json_encode(array('status' => 'success'));
    } else {
      echo json_encode(array('status' => 'error'));
    }
  }

  public function createAdmin($data){

  }


  public function login($data, $files) {

    $user = Usuario::exist($data['usuario'], $data['password']);
    if ($user->idUsuario == 0) {
      echo json_encode(array('status' => 'error', 'message' => 'No existe un usuario con esas credenciales'));
    } else {
      setcookie('user_obj', json_encode($user), time() + 64800, '/', false);
      echo json_encode(array('status' => 'success', 'user' => $user));
    }
  }
  public function logout() {
    try {
      setcookie('user_obj', '', time() - 64800, '/', false);
      unset($_COOKIE['user_obj']);
      echo json_encode(array('status' => 'success'));
    } catch (\Throwable $th) {
      echo json_encode(array('status' => 'error', 'message' => $th->getMessage()));
    }
  }

  public function getallUsers() {
    if (!isset($_COOKIE['user_obj'])) {
      echo json_encode(array('status' => 'error', 'message' => 'Cookies de sesion necesarias'));
    } else {
      try {
        $users = Usuario::getAllUsers();
        echo json_encode(array('status' => 'success', 'data' => json_encode($users)));
      } catch (\Throwable $th) {
        print_r($th);
      }
    }
  }
  public function changepass($data, $files = null) {
    $id = $data['idUsuario'];
    $pass = $data['pass'];
    $new = $data['newPass'];
    $usuario = new Usuario($id);
    if ($usuario->idUsuario == 0) {
      echo json_encode(array('status' => 'error', 'message' => 'No existe el usuario | idUsuario incorrecto'));
    } else if ($usuario->password != hash('sha256', $pass)) {
      echo json_encode(array('status' => 'error', 'message' => 'La contraseña anterior es incorrecta'));
    } else {
      $res = $usuario->newPass($new);
      if ($res > 0) {
        echo json_encode(array('status' => 'success', 'message' => 'La contraseña fue cambiada exitosamente'));
      } else {
        echo json_encode(array('status' => 'error', 'message' => 'Ocurrió un error al cambiar la contraseña, intenta más tarde'));
      }
    }
  }

  public function changecolor($data, $files = null) {
    $id = $data['idUsuario'];
    $color = $data['color'];
    $user = new Usuario($id);
    if ($user->idUsuario != 0 && $color != '') {
      $user->color = $color;
      $res = $user->save();
      if ($res > 0) {
        setcookie('user_obj', json_encode($user), time() + 64800, '/', false);
        echo json_encode(['status' => 'success', 'message' => 'Cambio correcto']);
      } else {
        echo json_encode(['status' => 'error', 'message' => 'Error inesperado']);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'No de puede guardar, datos faltantes']);
    }
  }

  public function delete($data) {
    $id = $data['idUsuario'];
    $usuario = new Usuario($id);
    if ($usuario->idUsuario == 0) {
      echo json_encode(array('status' => 'error', 'message' => 'No existe el usuario | idUsuario incorrecto'));
    } else {
      $res = $usuario->delete();
      if ($res > 0) {
        echo json_encode(array('status' => 'success', 'message' => 'El usuario fue eliminado exitosamente'));
      } else {
        echo json_encode(array('status' => 'error', 'message' => 'Ocurrió un error al eliminar el usuario, intenta más tarde'));
      }
    }
  }
  public function update($data) {
    $idUsuario = $data['idUsuario'];
    $user = $data['usuario'];
    $rol = $data['rol'];
    $usuario = new Usuario($idUsuario);
    if ($usuario->idUsuario == 0) {
      echo json_encode(array('status' => 'error', 'message' => 'No existe el usuario | idUsuario incorrecto'));
    } else {
      $usuario->usuario = $user;
      $usuario->rol = $rol;
      $usuario->nombre = $data['nombre'];
      $res = $usuario->save();
      if ($res > 0) {
        echo json_encode(array('status' => 'success', 'message' => 'El usuario fue actualizado exitosamente'));
      } else {
        echo json_encode(array('status' => 'error', 'message' => 'Ocurrió un error al actualizar el usuario, intenta más tarde'));
      }
    }
  }

  public function resetPass($data) {
    $id = $data['idUsuario'];
    $usuario = new Usuario($id);
    if ($usuario->idUsuario == 0) {
      echo json_encode(array('status' => 'error', 'message' => 'No existe el usuario | idUsuario incorrecto'));
    } else {
      $usuario->password = hash('sha256', $usuario->usuario);
      $res = $usuario->save();
      if ($res > 0) {
        echo json_encode(array('status' => 'success', 'message' => 'La contraseña fue cambiada exitosamente'));
      } else {
        echo json_encode(array('status' => 'error', 'message' => 'Ocurrió un error al cambiar la contraseña, intenta más tarde'));
      }
    }
  }

}
