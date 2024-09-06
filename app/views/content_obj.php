<ol>
  <?php foreach($objetivos as $objetivo): ?>
  <li><?= $objetivo->objetivoEspecifico ?></li>
  <?php endforeach; ?>
</ol>
<style>
  li::marker{
    font-weight: bold;
  }
</style>