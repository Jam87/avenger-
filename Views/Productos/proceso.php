<div id="form-registrar" class="row justify-content-center" style="display:none;">
    <div class="col-xxl-9">
        <div class="card-header">
            <a onClick=""><i class="fas fa-save"></i></i> Guardar</a>
        </div>
		
        <div class="card">
			<h2 style="padding: 22px 0px 0px 22px;">Gestión de Productos</h2>
            <i class="ri-close-circle-line close_popup" onClick="close_popup()"></i>

            <div class="card-body p-4">
                <!--Begin Row -->
                <div class="row g-3">
                        <div class="col-lg-3 col-sm-6">
							<label>Familia</label>
                            <select id="cmbFamilia" name="cmbFamilia" class="form-select mb-3" required>
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>Nombre</label>
							<input id="txtNombre" name="txtNombre" type="text" class="form-control bg-light border-0"  placeholder="Escriba el nombre del producto"/>
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>Precio Minimo</label>
                            <input type="number" class="form-control bg-light border-0" step="1" min="0" placeholder="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" id="txtMinimo" name="txtMinimo" />
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>Precio Maximo</label>
							<input type="number" class="form-control bg-light border-0" step="1" min="0" placeholder="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" id="txtMaximo" name="txtMaximo" />
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>Precio de Venta</label>
							<input type="number" class="form-control bg-light border-0" step="1" min="0" placeholder="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" id="txtVenta" name="txtVenta" />
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>Altura</label>
							<input type="number" class="form-control bg-light border-0" step="1" min="0" placeholder="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" id="txtAltura" name="txtAltura" />
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>Largo</label>
							<input type="number" class="form-control bg-light border-0" step="1" min="0" placeholder="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" id="txtLargo" name="txtLargo" />
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>Grosor</label>
							<input type="number" class="form-control bg-light border-0" step="1" min="0" placeholder="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" id="txtGrosor" name="txtGrosor" />
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>Unidad de Medida</label>
                            <select id="cmbUnidad" name="cmbUnidad" class="form-select mb-3" required>
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>TAE</label>
                            <input type="number" class="form-control bg-light border-0" step="1" min="0" placeholder="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" id="txtTAE" name="txtTAE" />
                        </div>
						
                        <div class="col-lg-3 col-sm-6">
							<label>TDE</label>
							<input type="number" class="form-control bg-light border-0" step="1" min="0" placeholder="0.00" onblur="formatNumber(this, 2); control_fill(this);" onkeypress="formatNumber(this, 2)" onfocus="control_clear(this)" id="txtTDE" name="txtTDE" />
                        </div>
						
                        <div>
							<label>Descripción</label>
							<textarea id="txtDescripcion" name="txtDescripcion" class="form-control bg-light border-0" ></textarea>
                        </div>
						
                        <div>
							<label>Etiquetas</label>
							<textarea id="txtEtiquetas" name="txtDescripcion" class="form-control bg-light border-0" ></textarea>
                        </div>
                </div>
                <!--End Row ---->
            </div>

        </div>
							
    </div>
</div>