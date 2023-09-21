<!--MODAL DE KARDEX-->
<div id="modalKardex" class="modal zoomIn" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
                <form method="post" id="formKardex" name="formKardex">
                    <input type="hidden" id="idKardex" name="idKardex" value="">
                    <div class="modal-body">

                        <div class="row">
                            <div class="p-0 col-xl-12">
                                <div>
                                    <div>
                                        <!--GRUPO 1-->
                                        <div class="form-group">
                                            <div class="row">
                                                <!--Color-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Color<span class="text-danger"> *</span></label>
                                                    <select class="form-select mb-3" id="comboxColor" name="comboxColor">

                                                    </select>
                                                </div>

                                                <!--Presentacion-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Presentación<span class="text-danger"> *</span></label>
                                                    <select class="form-select mb-3" id="comboxPresent" name="comboxPresent">

                                                    </select>
                                                </div>

                                                <!--Talla-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Talla<span class="text-danger"> *</span></label>
                                                    <select class="form-select mb-3" id="comboxTalla" name="comboxTalla">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!--GRUPO 2-->
                                        <div class="form-group">
                                            <div class="row">
                                                <!--Bodega-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Bodega<span class="text-danger"> *</span></label>
                                                    <select class="form-select mb-3" id="comboxBodega" name="comboxBodega">

                                                    </select>
                                                </div>
                                                <!--Consecutivo-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Consecutivo<span class="text-danger"> *</span></label>
                                                    <div><!-- disabled, readonly -->
                                                        <input type="number" class="form-border" name="consecutivo" id="consecutivo" disabled>
                                                    </div>
                                                </div>

                                                <!--Movimiento-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Movimientos<span class="text-danger"> *</span></label>
                                                    <input type="number" class="form-border" name="consecutivo" id="consecutivo">
                                                </div>


                                            </div>
                                        </div><!-- Fin: grupo2 -->

                                        <!--GRUPO 3-->
                                        <div class="form-group">
                                            <div class="row">
                                                <!--Existencia anterior-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Existencia anterior<span class="text-danger"> *</span></label>
                                                    <input type="text" class="form-border" name="ruc" id="ruc" placeholder="Digite" autocomplete="off" required>
                                                </div>

                                                <!--Existencia nueva-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Existencia nueva<span class="text-danger"> *</span></label>
                                                    <input type="text" class="form-border" name="ruc" id="ruc" placeholder="Digite" autocomplete="off" required>
                                                </div>

                                                <!--Existencia anterior-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Fecha documento<span class="text-danger"> *</span></label>
                                                    <input type="text" class="form-control" placeholder="DD-MM-YYYY" id="cleave-date">
                                                </div>


                                            </div>
                                        </div><!-- Fin: grupo2 -->
                                        <br>
                                        <!--GRUPO 4-->
                                        <div class="form-group">
                                            <div class="row">
                                                <!--Movimiento-->
                                                <div class="col-sm-4">
                                                    <label for="pais">Último movimiento<span class="text-danger"> *</span></label>
                                                    <select class="form-select mb-3" id="comboxPago" name="comboxPago">

                                                    </select>
                                                </div>

                                                <!--Existencia nueva-->
                                                <div class="col-sm-4">
                                                    <label for="nombre">Estado <span class="text-danger">*</span></label>
                                                    <select class="form-select mb-3" id="lStatus" name="lStatus" required>
                                                        <option value="1">Activo</option>
                                                        <option value="2">Inactivo</option>
                                                    </select>
                                                </div>


                                            </div>
                                        </div><!-- Fin: grupo2 -->

                                    </div>

                                    <!--end col-->
                                </div>
                            </div><!-- end card header -->

                            <!-- end col -->
                        </div><!--Fin: 1 card-->

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