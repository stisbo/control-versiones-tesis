<?php
namespace App\Resources;
class View{
  public static function render(string $name_view, array $data): string{
    extract($data);
    if(self::view_exist($name_view)){
      ob_start();
      require_once __DIR__ . '/../views/'.$name_view.'.php';
      $content = ob_get_clean();
    }else{
      $content = '<div class="alert alert-danger">Ocurrio un error, no se pudo cargar la vista.<hr> 
      Error code: view <b>' .$name_view. ' 404</b></div>';
    }
    return $content;
  }
  public static function view_exist(string $name_view): bool{
    $urlDir = __DIR__ . '/../views/'.$name_view.'.php';
    return file_exists($urlDir);
  }
}