
<div class="card" id="frmProveedor" style="display:none;">
	<i class="ri-close-circle-line close close_popup"></i>
	
    <div class="card-header">
        <div class="row g-2">
            <div class="col-md-3">
                <div class="search-box">
                    <input id="txtpbuscar" type="text" class="form-control search" placeholder="Search for company...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div>
            <div class="table-responsive table-card mb-3">
                <table class="table align-middle table-nowrap mb-0 myTable" id="proveedorTable">
                    <thead class="table-light">
                        <tr>
                            <th class="sort" data-sort="codigo" scope="col">Código</th>
                            <th class="sort" data-sort="name" scope="col">Nombre</th>
                            <th class="sort" data-sort="contacto" scope="col">Contacto</th>
                            <th class="sort" data-sort="pais" scope="col">Pais</th>
                            <th class="sort" data-sort="pago" scope="col">Forma de pago</th>
                        </tr>
                    </thead>
                    <tbody id="tblProveedores" class="list">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
