<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Ajouter un produit</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-6">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du produit : </label>
                    <input type="text" class="form-control" name="name" <?= isset($_POST['name']) ? 'value="' . htmlspecialChars($_POST['name']) . '"' : '' ?>>
                </div>
                <div class="mb-3">
                    <label for="stockMin" class="form-label">Stock Minimal : </label>
                    <input type="number" class="form-control" name="stockMin" <?= isset($_POST['stockMin']) ? 'value="' . htmlspecialChars($_POST['stockMin']) . '"' : '' ?>>
                </div>
                <div class="mb-3">
                    <label for="stockActual" class="form-label">Stock Actuel : </label>
                    <input type="number" class="form-control" name="stockActual" <?= isset($_POST['stockActual']) ? 'value="' . htmlspecialChars($_POST['stockActual']) . '"' : '' ?>>
                </div>
                <!-- <div class="btn-group mb-3" role="group" aria-label="Basic checkbox toggle button group">
                    <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off" name="recurent">
                    <label class="btn btn-outline-primary" for="btncheck1">Produit Récurrent</label>
                </div> -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="recurent" value="on" name="recurent">
                    <label class="form-check-label" for="recurent">
                        Recurrent
                    </label>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" name="createProduct" value="Valider">
                </div>
            </form>
            <?php if (strlen($errors) !== 0) : ?>
                <div class="bg-danger my-3 p-2">
                    <p class="text-center">
                        <?= $errors ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>