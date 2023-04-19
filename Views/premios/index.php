<?php include 'Views/templates/header.php' ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="page-description">
                <h1><?php echo $data['title']; ?></h1>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-outline-primary" type="button" id="btnNuevoPremio" name="btnNuevoPremio">Nuevo</button>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover display nowrap" style="width: 100%;" id="tablaPremios">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Caracteristicas</th>
                                    <th>imagen</th>
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
                <input type="hidden" name="idpremio" id="idpremio">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre de premio </label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                        <div class="col-md-6">
                            <label for="image" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <img id="preview" name="preview" src="<?php echo $data['url']; ?>/Assets/images/regalo.jpg" alt="Sin Foto" width="100" height="100">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="caracteristicas" class="form-label">Caracteristicas</label>
                            <input type="text" class="form-control" id="caracteristicas" name="caracteristicas">
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