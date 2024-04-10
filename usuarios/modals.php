<!-- Modal nuevo ingreso -->
<div class="modal fade" id="modal_usuario_nuevo" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-primary" role="alert">
          Crear un usuario y de acuerdo al<strong> rol </strong> podra editar y ver los proyectos.
        </div>
        <form id="form_nuevo_user">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="user_alias" placeholder="usuario" value="" name="alias">
            <label for="user_alias">Ingrese un usuario</label>
          </div>
          <div class="mb-2">
            <select class="form-select" name="rol">
              <option value="VISOR">VISOR</option>
              <option value="EDITOR">EDITOR</option>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_modal_user">Registrar suario</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal editar usuario -->
<div class="modal fade" id="modal_usuario_edit" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Editar Usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form_user_edit" onsubmit="return false;">
          <input type="hidden" name="idUsuario" id="id_usuario_edit">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="user_alias_edit" placeholder="usuario" value="" name="alias">
            <label for="user_alias">Usuario </label>
          </div>
          <div class="mb-2">
            <select class="form-select" name="rol" id="user_rol_edit"></select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="updateUser()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar usuario -->
<div class="modal fade" id="modal_delete_usuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h1 class="modal-title fs-5">Eliminar usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idUsuario_delete" value="0">
        <div class="mb-2">
          <p class="fs-4">
            ¿Está seguro que desea eliminar al usuario?
          </p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="deleteUser()">Sí, eliminar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal reset password  usuario -->
<div class="modal fade" id="modal_reset_pass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
        <h1 class="modal-title fs-5">Restablecer password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idUsuario_reset_pass" value="0">
        <div class="mb-2">
          <div class="alert alert-warning text-center fs-5" role="alert">
            Si acepta la nueva contraseña será el mismo usuario.
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="user_reset_pass()">Aceptar</button>
      </div>
    </div>
  </div>
</div>