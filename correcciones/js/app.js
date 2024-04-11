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
async function showData(a,b){
  console.log(a, b)

  $("#myTabContent").html(`<h1>${a} ----- ${b}</h1>`);

  
}