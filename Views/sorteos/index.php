<?php include 'Views/templates/header.php' ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="page-description">
                <h1><?php echo $data['title']; ?></h1>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-outline-primary" type="button" id="btnNuevoSorteo" name="btnNuevoSorteo">Nuevo</button>

            <div class="card">
                <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover display nowrap" style="width: 100%;" id="tablasorteos">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Fecha inicio</th>
                                        <th>Fecha de sorteo</th>
                                        <th>Intentos</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>

                            </table>
                        </div>

                </div>
            </div>

        </div>
    </div>

</div>

<div id="modalRegistroPremio" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlepremio"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formulariopremios" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="idsorteopremio" id="idsorteopremio">
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="intentos" class="form-label">Acciones</label>
                            <button type="button" id="agregarPremio">
                                <i class="material-icons-two-tone">add</i>
                            </button>
                        </div>

                        <div id="premiosdinamicos">

                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="guardarPremios">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                </div>
            </form>
        </div>
    </div>
</div>


<div id="modalRegistro" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="formulario" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="idsorteo" id="idsorteo">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre de sorteo </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="intentos" class="form-label">Intentos</label>
                            <input type="number" class="form-control" id="intentos" name="intentos" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="fechainicio" class="form-label">Fecha inicio</label>
                            <input type="date" class="form-control" id="fechainicio" name="fechainicio" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fechafin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fechafin" name="fechafin" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                </div>

            </form>



        </div>
    </div>
</div>



<?php include 'Views/templates/footer.php' ?>