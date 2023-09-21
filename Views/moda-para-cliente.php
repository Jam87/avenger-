<!--MODAL DE CONTACTO-->
<div id="modalContacto" class="modal zoomIn" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header bg-pattern p-3 headerRegister">
                <h4 class="card-title mb-0" id="titleModal">Nuevo usuario</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-warning  rounded-0 mb-0">
                <i class="ri-alert-line me-3 align-middle"></i><b><?= $data['page_title_bold']; ?></b>
                <?= $data['descrption_modal1']; ?><span class="text-danger"> * </span><?= $data['descrption_modal2']; ?>
            </div>
            <div class="modal-body">
                <!-- TODO: Formulario de Mantenimiento -->
                <form method="post" id="formContacto" name="formContacto">
                    <input type="hidden" id="idContacto" name="idContacto" value="">
                    <div class="modal-body">
                        <!--GRUPO 1-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="formulario__grupo" id="grupo__nombre">
                                        <label for="nombre">Nombre <span class="text-danger">*</span></label>

                                        <div class="formulario__grupo-input">
                                            <input type="text" class="form-border" name="descripcion" id="descripcion" placeholder="Escriba el nombre completo" required>
                                        </div>

                                    </div><!-- Fin: nombre -->
                                </div>

                                <div class="col-sm-4">
                                    <div class="formulario__grupo" id="grupo__apellido">
                                        <label for="nombre">Ruc<span class="text-danger">*</span></label>

                                        <div class="formulario__grupo-input">
                                            <input type="text" class="form-border" id="telefono" name="telefono" pattern="[0-9]+" placeholder="# Ruc" required>
                                        </div>
                                    </div><!-- Fin:# ruc -->
                                </div>

                                <div class="col-sm-4">
                                    <label for="exampleSelect1">Pais<span class="text-danger">*</span></label>
                                    <select class="form-select mb-3" id="listLocal" name="listLocal" required>
                                       
                                    </select>
                                </div> <!--Fin Select-->

                              
                            </div>
                        </div><!-- Fin: grupo1 -->
                        <br>
                        <!--GRUPO 2-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="formulario__grupo" id="grupo__apellido">
                                        <label for="nombre">Correo <span class="text-danger">*</span></label>

                                        <div class="formulario__grupo-input">
                                            <input type="text" class="form-border" name="correo" id="correo" placeholder="Ingrese un correo" required>
                                        </div>
                                    </div><!-- Fin: correo-->
                                </div>

                                <div class="col-sm-6">
                                    <div class="formulario__grupo" id="grupo__apellido">
                                        <label for="nombre">Sitio web</label>

                                        <div class="formulario__grupo-input">
                                            <input type="text" class="form-border" name="web" id="web" placeholder="Ingrese el sitio web">
                                        </div>
                                    </div><!-- Fin: correo-->
                                </div>
                            </div>
                        </div><!-- Fin: grupo2 -->
                        <br>

                        <!--GRUPO 4-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="formulario__grupo" id="grupo__nombre">
                                        <label for="nombre">Estado <span class="text-danger">*</span></label>

                                        <select class="form-select mb-3" id="lStatus" name="lStatus" required>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>

                                    </div><!-- Fin: username -->
                                </div>
                            </div>
                        </div><!-- Fin: grupo4 -->
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" id="btnActionForm" name="action" value="add" class="btn btn-primary "><span id="btnText">Guardar</span></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->