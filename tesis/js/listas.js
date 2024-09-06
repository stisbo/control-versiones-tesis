$(document).ready(function () {
  $("#tabla_tesis").DataTable({
    language: lenguaje,
    info: false,
    scrollX: true,
    columnDefs: [
      // { orderable: false, targets: [5, 7] }
    ],
  })
})
$(document).on('show.bs.modal', '#modal_objetivos', modal_ver_objetivos);
async function modal_ver_objetivos(event) {
  const button = $(event.relatedTarget)
  const id = button.data('id')
  $("#objetivos_content").load(`../app/tesis/objetivos_esp`, { idTesis: id })
}