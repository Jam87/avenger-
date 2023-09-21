<!--MODAL DE CLIENTES-->
<div id="modalClientes" class="modal zoomIn" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 overflow-hidden" style="background: #F2F2F2 !Important;">
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
                <form method="post" id="formClientes" name="formClientes">
                    <input type="hidden" id="idClientes" name="idClientes" value="">
                    <div class="modal-body">

                        <div class="row">
                            <div class="">
                                <div class="card pag-title-box">
                                    <div class="pag-title-box">
                                        <h4 class="card-title mb-0 flex-grow-1">Datos generales</h4>
                                        <div>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="p-3 col-xl-12">
                                        <div>
                                            <div>
                                                <!--GRUPO 1-->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-border" name="nombre" id="nombre" placeholder="Escriba el nombre">
                                                        </div><!--Nombre-->

                                                        <div class="col-sm-4">
                                                            <label for="nombre">Ruc <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-border" name="ruc" id="ruc" placeholder="Digite el ruc">
                                                        </div><!--Ruc-->

                                                        <div class="col-sm-4">
                                                            <label for="pais">Pais<span class="text-danger">*</span></label>
                                                            <select class="form-select mb-3" id="comboxPais" name="comboxPais">

                                                            </select>
                                                        </div><!--Pais-->
                                                    </div>
                                                </div>

                                                <!--GRUPO 2-->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label for="pais">Persona ontacto<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-border" name="personaContacto" id="personaContacto" placeholder="Persona contacto">
                                                        </div><!--Contacto-->

                                                        <div class="col-sm-4">
                                                            <label for="pais">Forma de pago<span class="text-danger">*</span></label>
                                                            <select class="form-select mb-3" id="comboxPago" name="comboxPago">

                                                            </select>
                                                        </div><!--Forma pago-->

                                                        <div class="col-sm-4">
                                                            <label for="Excento">Excento impuesto <span class="text-danger">*</span></label>

                                                            <select class="form-select mb-3" id="statusImpuesto" name="statusImpuesto">
                                                                <option value="1">Si</option>
                                                                <option value="2">No</option>
                                                            </select>
                                                        </div>


                                                    </div>
                                                </div><!-- Fin: grupo2 -->

                                                <!--GRUPO 3-->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label for="nombre">Estado <span class="text-danger">*</span></label>
                                                            <select class="form-select mb-3" id="lStatus" name="lStatus">
                                                                <option value="1">Activo</option>
                                                                <option value="2">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div><!-- Fin: grupo3 -->

                                            </div>

                                            <!--end col-->
                                        </div>
                                    </div><!-- end card header -->


                                </div><!-- end card -->
                            </div><!-- end col -->
                            <!-- end col -->
                        </div><!--Fin: 1 card-->

                        <div class="row">
                            <div class="">
                                <div class="card pag-title-box2">
                                    <div class="pag-title-box2">
                                        <h4 class="card-title mb-0 flex-grow-1">Datos contacto</h4>
                                        <div>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="row">
                                        <div class="col-xxl-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label for="movil">Móvil <span class="text-danger">* </span></label>
                                                        <input type="number" class="form-border" name="movil" id="movil" placeholder="Digite el celular">
                                                    </div><!--Nombre-->

                                                    <div class="col-sm-4">
                                                        <label for="telefono">Teléfono</label>
                                                        <input type="number" class="form-border" name="telefono" id="telefono" placeholder="Digite el teléfono">
                                                    </div><!--Ruc-->

                                                    <div class="col-sm-2">
                                                        <label for="extension">Extensión </label>
                                                        <input type="number" class="form-border" name="extension" id="extension" placeholder="Digite la extensión">
                                                    </div><!--Ruc-->
                                                </div>
                                            </div>
                                            <!--GRUPO 1-->
                                            <br>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label for="correo">Correo <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-border" name="correo" id="correo" placeholder="Escriba el correo">
                                                    </div><!--Nombre-->

                                                    <div class="col-sm-6">
                                                        <label for="direccion">Dirección</label>
                                                        <textarea name="direccion" class="form-border" placeholder="Escriba la dirección" id="" cols="80"></textarea>
                                                    </div><!--Ruc-->


                                                </div>
                                            </div>


                                        </div>
                                        <!--end col-->
                                    </div>


                                </div><!-- end card -->
                            </div><!-- end col -->
                            <!-- end col -->
                        </div> <!--Fin: 2 card-->



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