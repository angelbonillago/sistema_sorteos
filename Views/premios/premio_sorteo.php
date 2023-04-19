<?php include 'Views/templates/header.php' ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col text-center">
            <div class="page-description">
                <h1><?php echo $data['title']; ?></h1>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">

        <form action="" class="col-md-8">

            <div class="row">
                <div class="col-md-6">
                    <label for="validationCustom04" class="form-label">State</label>
                    <select class="form-select" id="validationCustom04" required>
                        <option selected disabled value="">Choose...</option>
                        <option>...</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid state.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="validationCustom05" class="form-label">City</label>
                    <select class="form-select" id="validationCustom05" required>
                        <option selected disabled value="">Choose...</option>
                        <option>...</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid city.
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">Guardar</button>

                </div>
                <div class="col-md-4">
                    <button type="reset" class="btn btn-secondary btn-block">Cancelar</button>
                </div>
            </div>

        </form>
    </div>
</div>




<?php include 'Views/templates/footer.php' ?>