async function corregirTitulo(idTesis){
  const valor = $("#correccion_titulo").val();
  const res = await $.ajax({
    url: '../app/correccion/corregirTitulo',
    type: 'POST',
    data: { valor, idTesis },
    dataType: 'json', 
  })
  if(res.status){
    showToast("Operación exitosa", "Título corregido con éxito", "success")
    setTimeout(() => {
      location.reload();
    }, 1900);
  }else{
    showToast("Operación fallida", "Título no corregido", "error")
  }
}
async function corregirObjetivo(idTesis){
  const valor = $("#correccion_objetivo").val();
  const res = await $.ajax({
    url: '../app/correccion/corregirObjetivo',
    type: 'POST',
    data: { valor, idTesis },
    dataType: 'json',
  })
  if(res.status){
    showToast("Operación exitosa", "Objetivo corregido con éxito", "success")
    setTimeout(() => {
      location.reload();
    }, 1900);
  }else{
    showToast("Operación fallida", "Objetivo no corregido", "error")
  }
}

$(document).on('show.bs.modal', '#modal_editar_objetivos', cargarDatos);

async function cargarDatos(e){
  const idTesis = e.relatedTarget.dataset.id;
  $("#body_obj_esp_edit").load('../app/tesis/cargar_obj_esp', {idTesis})
}

async function agregarNuevoObjEsp(){
  const c = Number($("#cantidad_objetivos").val())
  if(c < 5){
    $("#contenedor_nuevos").append(`
    <div class="from-group mt-3">
    <label>Objetivo específico ${c+1}</label>
      <textarea class="form-control" name="obj_esp_nuevo[]" style="height:110px;resize:none;"></textarea>
    </div>
    `);
    $("#cantidad_objetivos").val(c+1)
  }else{
    showToast("Cantidad excedida", "No puede agregar mas de 5 objetivos", "error")
  }
}

async function guardarCambioObjEsp(){
  const data = $("#form_edit_obj_esp").serializeArray();
  const res = await $.ajax({
    url: '../app/correccion/corregir_obj_esp',
    data,
    dataType: 'json'
  })
  if(res.status){
    showToast("Procesado cone éxito", "Objetivos corregidos", "success")
    setTimeout(() => {
      location.reload();
    }, 1900);
  }else{
    showToast("Cantidad excedida", "No puede agregar mas de 5 objetivos", "error")  
  }
}