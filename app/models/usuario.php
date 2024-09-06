<?php // propietario -> usuario principal
namespace App\Models;

use App\Config\Database;

class Usuario {
  public int $idUsuario;
  public string $nombre;
  public string $apellidos;
  public string $usuario; // correo electronico
  public string $rol;
  public string $password;
  public string $color; // color de menu
  public string $creado_en;
  public string $celular;
  public function __construct($idUsuario = null) {
    if ($idUsuario != null) {
      $con = Database::getInstace();
      $sql = "SELECT * FROM tblUsuario WHERE idUsuario = :idUsuario";
      $stmt = $con->prepare($sql);
      $stmt->execute(['idUsuario' => $idUsuario]);
      $row = $stmt->fetch();
      if ($row) {
        $this->load($row);
      } else {
        $this->objectNull();
      }
    } else {
      $this->objectNull();
    }
  }

  public function objectNull() {
    $this->idUsuario = 0;
    $this->nombre = 'Invitado';
    $this->apellidos = '';
    $this->usuario = '';
    $this->rol = '';
    $this->password = '';
    $this->color = '#212529';
    $this->creado_en = '';
    $this->celular = '';
  }


  public function resetPass() {
    try {
      $con = Database::getInstace();
      $sql = "UPDATE tblUsuario SET password = :password WHERE idUsuario = :idUsuario";
      $stmt = $con->prepare($sql);
      $pass = hash('sha256', $this->usuario);
      return $stmt->execute(['password' => $pass, 'idUsuario' => $this->idUsuario]);
    } catch (\Throwable $th) {
      return -1;
    }
  }
  public function newPass($newPass) { /// cambio de password
    try {
      $con = Database::getInstace();
      $sql = "UPDATE tblUsuario SET password = :password WHERE idUsuario = :idUsuario";
      $stmt = $con->prepare($sql);
      $pass = hash('sha256', $newPass);
      $stmt->execute(['password' => $pass, 'idUsuario' => $this->idUsuario]);
      return 1;
    } catch (\Throwable $th) {
      return -1;
    }
  }
  public function save() {
    try {
      $con = Database::getInstace();
      if ($this->idUsuario == 0) { //insert
        $sql = "INSERT INTO tblUsuario (usuario, nombre, apellidos, rol, color, password, celular) VALUES (:usuario, :nombre, :apellidos, :rol, :color, :password, :celular)";
        $params = ['usuario' => $this->usuario, 'nombre' => $this->nombre, 'rol' => $this->rol, 'color' => '#212529', 'password' => $this->password, 'apellidos' => $this->apellidos, 'celular' => $this->celular];
        $stmt = $con->prepare($sql);
        $res = $stmt->execute($params);
        if ($res) {
          $this->idUsuario = $con->lastInsertId();
          $res = $this->idUsuario;
        }
      } else { // update
        $sql = "UPDATE tblUsuario SET usuario = :usuario, nombre = :nombre, apellidos = :apellidos, rol = :rol, color = :color, celular = :celular WHERE idUsuario = :idUsuario";
        $params = ['usuario' => $this->usuario, 'nombre' => $this->nombre, 'apellidos'=> $this->apellidos, 'rol' => $this->rol, 'color' => $this->color, 'celular' => $this->celular, 'idUsuario' => $this->idUsuario];
        $stmt = $con->prepare($sql);
        $stmt->execute($params);
        $res = 1;
      }
      return $res;
    } catch (\Throwable $th) {
      print_r($th);
      return -1;
    }
  }

  public function load($row) {
    $this->idUsuario = $row['idUsuario'];
    $this->nombre = $row['nombre'];
    $this->usuario = $row['usuario'];
    $this->rol = $row['rol'];
    $this->color = $row['color'];
    $this->password = $row['password'];
    $this->apellidos = $row['apellidos'];
    $this->creado_en = $row['creado_en'];
    $this->celular = $row['celular'] ?? '000';
  }
  public function delete() {
    try {
      $con = Database::getInstace();
      $sql = "DELETE FROM tblUsuario WHERE idUsuario = :idUsuario";
      $stmt = $con->prepare($sql);
      $stmt->execute(['idUsuario' => $this->idUsuario]);
      return 1;
    } catch (\Throwable $th) {
      return -1;
    }
  }
  public static function exist($usuario, $pass): Usuario {
    $con = Database::getInstace();
    $sql = "SELECT * FROM tblUsuario WHERE usuario = :usuario AND password = :password";
    $passHash = hash('sha256', $pass);
    $stmt = $con->prepare($sql);
    $stmt->execute(['usuario' => $usuario, 'password' => $passHash]);
    $row = $stmt->fetch();
    $usuario = new Usuario();
    if ($row) {
      $usuario->load($row);
      return $usuario;
    } else {
      return $usuario;
    }
  }

  public static function userExist($usuario) {
    $con = Database::getInstace();
    $sql = "SELECT * FROM tblUsuario WHERE usuario = :usuario";
    $stmt = $con->prepare($sql);
    $stmt->execute(['usuario' => $usuario]);
    $row = $stmt->fetch();
    if ($row) {
      return true;
    } else {
      return false;
    }
  }

  public static function getAllUsers() {
    $con = Database::getInstace();
    $sql = "SELECT * FROM tblUsuario";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    return $rows;
  }
}
