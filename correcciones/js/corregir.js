async function guardarCommentTitulo(){
  const idTarget = $("#idTarget_titulo").val();
  const comentario = $("#titulo_coment").val();
  const correccion = $("#esCorreccion_titulo").val();
  const res = await $.ajax({
    url: '../app/revision/revisarTitulo',
    type: 'POST',
    data: { idTarget, comentario, correccion },
    dataType: 'json'
  })
  if(res.status){
    showToast('Operación exitosa (TITULO)', 'Mensaje enviado y registrado', 'success');
    setTimeout(() => {
      location.reload();
    }, 1600);
  } else{
    showToast('Operación fallida (OBJETIVO)', 'Mensaje no enviado', 'error');
  }
}

async function guardarCommentObjetivo(){
  const idTarget = $("#idTarget_obj").val();
  const comentario = $("#objetivo_coment").val();
  const correccion = $("#esCorreccion_obj").val();
  const res = await $.ajax({
    url: '../app/revision/revisarObjetivo',
    type: 'POST',
    data: { idTarget, comentario, correccion },
    dataType: 'json'
  });
  if(res.status){
    showToast('Operación exitosa (OBJETIVO)', 'Mensaje enviado y registrado', 'success');
    setTimeout(() => {
      location.reload();
    }, 1660);
  }else{
    showToast('Operación fallida (OBJETIVO)', 'Mensaje no enviado', 'error');
  }
}