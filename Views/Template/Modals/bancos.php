<!--MODAL BANCOS-->
<div id="modalBancos" class="modal zoomIn" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header bg-pattern p-3 headerRegister">
                <h4 class="card-title mb-0" id="titleModal">Nuevo Tipo de usuario</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-warning  rounded-0 mb-0">
                <i class="ri-alert-line me-3 align-middle"></i><b><?= $data['page_title_bold']; ?></b>
                <?= $data['descrption_modal1']; ?><span class="text-danger"> * </span><?= $data['descrption_modal2']; ?>
            </div>
            <div class="modal-body">
                <form method="post" id="formBanco" name="formBanco">

                    <input type="hidden" id="idBanco" name="idBanco" value="">
                    <div class="mb-3">
                        <label for="Nombre" class="form-label">Nombre de banco <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Nombre tipo de usuario" required>
                    </div><!--Fin nombre-->
                    <div class="mb-3">
                        <label for="exampleSelect1">Localidad<span class="text-danger">*</span></label>
                        <select class="form-select mb-3" id="listLocal" name="listLocal" required>
                            <option value="1">Nacional</option>
                            <option value="2">Internacional</option>
                        </select>
                    </div> <!--Fin Select-->
                    <div class="mb-3">
                        <label for="Description" class="form-label">Nota</label>
                        <textarea class="form-control" id="txtDescripcion" name="txtDescription" rows="2" placeholder="Descripción"></textarea>
                    </div><!--Fin description-->
                    <div class="mb-3">
                        <label for="exampleSelect1">Estado <span class="text-danger">*</span></label>
                        <select class="form-select mb-3" id="listStatus" name="listStatus" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div> <!--Fin Select-->
                    <div class="text-end">
                        <button id="btnActionForm" class="btn-primary" type="submit" class="btn btn-form"><span id="btnText">Guardar</span></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->