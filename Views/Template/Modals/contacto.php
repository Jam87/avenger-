<div id="modalContacto"" class=" modal zoomIn" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header bg-pattern p-3 headerRegister">
                <h4 class="card-title mb-0" id="titleModal"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-warning  rounded-0 mb-0">
                <i class="ri-alert-line me-3 align-middle"></i><b><?= $data['page_title_bold']; ?></b>
                <?= $data['descrption_modal1']; ?><span class="text-danger"> * </span><?= $data['descrption_modal2']; ?>
            </div>
            <div class="modal-body">
                <form method="post" id="formContacto" name="formContacto">
                    <input type="hidden" id="idContacto" name="idContacto" value="">

                    <div class="col-12">
                        <label for="Nombre" class="form-label">Descripción <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Escriba la descripción" required>
                    </div><!--Fin nombre-->

                    <!--GRUPO 1-->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2 espacio">
                                <label for="nombre"><b>Teléfono</b></label>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="SwitchTel" name="cbxTel" value="1">
                                        <label class="form-check-label" for="SwitchCheck3">Yes/No</label>
                                    </div>
                                </td>

                            </div>

                            <div class="col-sm-2 espacio">
                                <label for="nombre"><b>Correo</b></label>

                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck3" name="cbxCorreo" value="2">
                                        <label class="form-check-label" for="SwitchCheck3">Yes/No</label>
                                    </div>
                                </td>
                            </div>

                            <div class="col-sm-2 espacio">
                                <label for="nombre"><b>Url</b></label>

                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="SwitchCheck3" name="cbxUrl" value="3">
                                        <label class="form-check-label" for="SwitchCheck3">Yes/No</label>
                                    </div>
                                </td>
                            </div>
                        </div>
                    </div><!-- Fin: grupo1 -->

                    <div class="col-4">
                        <label for="exampleSelect1">Estado <span class="text-danger">*</span></label>
                        <select class="form-select mb-3" id="listStatus" name="listStatus">
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