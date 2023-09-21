
<div class="card" id="frmProductor" style="display:none;">
	<i class="ri-close-circle-line close_producto close_popup"></i>
	
    <div class="card-header">
        <div class="row g-2">
            <div class="col-md-3">
                <div class="search-box">
                    <input id="txtBuscarProducto" type="text" class="form-control search" placeholder="Search for company...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div>
            <div class="table-responsive table-card mb-3">
                <table class="table align-middle table-nowrap mb-0 myTable" id="productosTable">
                    <thead class="table-light">
                        <tr>
                            <th class="sort" data-sort="codigo" scope="col">Código</th>
                            <th class="sort" data-sort="name" scope="col">Familia</th>
                            <th class="sort" data-sort="contacto" scope="col">Producto</th>
                            <th class="sort" data-sort="pais" scope="col">U/M</th>
                            <th class="sort" data-sort="pago" scope="col">Altura</th>
							<th class="sort" data-sort="pago" scope="col">Largo</th>
							<th class="sort" data-sort="pago" scope="col">Grosor</th>
                        </tr>
                    </thead>
                    <tbody id="tblProductos" class="list">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
