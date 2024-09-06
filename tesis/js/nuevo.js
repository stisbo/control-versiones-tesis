var correlativo = 0;
var contenidoObj = {};
var imagen = false;
$(document).on('click', '#btn_add_obj', agregarObjetivo)
$(document).on('submit', '#form_nuevo', enviarDatos);

function agregarObjetivo(e) {
  const val = $("#obj_esp").val();

  if (val != '') {
    correlativo++;
    if(Object.keys(contenidoObj).length >= 5){
      $.toast({
        heading: 'Limite de Objetivos',
        text: 'No puede agregar más de 5 objetivos',
        showHideTransition: 'slide',
        icon: 'error'
      });
      return
    }else{
      $("#pila_objetivos").append(`
      <div class="col-md-6 position-relative" id="obj_esp_${correlativo}">
        <div class="form-floating mb-3">
          <textarea class="form-control" placeholder="Objetivo especifico" rows="4" style="height:145px;resize:none;" readonly>${val}</textarea>
          <label for="">Objetivo específico </label>
        </div>
        <button type="button" onclick="deleteobj(${correlativo})" class="btn btn-sm btn-danger rounded-pill position-absolute" style="bottom:15px;right:12px;"><i class="fa fa-solid fa-trash"></i></button>
      </div>
      `)
      contenidoObj[correlativo] = val
      $("#cant_obj_especificos").html(Object.keys(contenidoObj).length)
      $("#obj_esp").val('')
    }
  }
}

function deleteobj(id){
  $("#obj_esp_"+id).remove()
  delete contenidoObj[id]
  $("#cant_obj_especificos").html(Object.keys(contenidoObj).length)
}

async function enviarDatos(e){
  e.preventDefault();
  // const data = $(e.target).serializeArray();
  // console.log(data)
  if(Object.keys(contenidoObj).length <= 2){
    $.toast({
      heading: 'Error',
      text: 'Debe agregar al menos 3 objetivos',
      showHideTransition: 'slide',
      icon: 'error'
    });
    return;
  }
  const tipo = $("#toggles").is(':checked') ? 'TESIS' : 'PROYECTO';
  // data.push({name: 'o_especificos', value: JSON.stringify(contenidoObj), tipo })
  // console.log(data)
  const form_data = new FormData(e.target);
  form_data.append('o_especificos', JSON.stringify(contenidoObj))
  form_data.append('tipo', tipo)
  var input_image = document.getElementById('file_geografico');
  if (input_image.files && input_image.files[0]) {
    form_data.append('imagen', input_image.files[0]);
  }
  for (const pair of form_data.entries()) {
    console.log(pair[0]+ ', ' + pair[1]); 
  }

  // const res = await $.ajax({
  //   url: '../app/tesis/create',
  //   type:'POST',
  //   data: data,
  //   dataType: 'json'
  // });
  // if(res.status ){
  //   $.toast({
  //     heading: 'Exito',
  //     text: 'Tesis creada',
  //     showHideTransition: 'slide',
  //     icon: 'success'
  //   });
  //   setTimeout(() => {
  //     window.location.href = './ver.php'
  //   }, 2000);
  // }
}
$(document).on('change', '#toggles', (e) => {
  $("#j_ciencia").toggleClass('d-none')
})