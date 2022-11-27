<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Modifier un produit</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-6">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du produit : </label>
                    <input type="text" class="form-control" name="name" <?= isset($singleProduct) ? 'value="' . htmlspecialChars($singleProduct->name) . '"' : '' ?>>
                </div>
                <div class="mb-3">
                    <label for="stockMin" class="form-label">Stock Minimal : </label>
                    <input type="number" class="form-control" n name="stockMin" <?= isset($singleProduct) ? 'value="' . htmlspecialChars($singleProduct->stock_min) . '"' : '' ?>>
                </div>
                <div class="mb-3">
                    <label for="stockActual" class="form-label">Stock Actuel : </label>
                    <input type="number" class="form-control" name="stockActual" <?= isset($singleProduct) ? 'value="' . htmlspecialChars($singleProduct->stock_actual) . '"' : '' ?>>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="recurent" value="on" name="recurent">
                    <?php if ($singleProduct->recurrent) : ?>
                        <input class="form-check-input" type="checkbox" id="recurent" value="on" name="recurent" checked>
                    <?php else : ?>
                        <input class="form-check-input" type="checkbox" id="recurent" value="on" name="recurent">
                    <?php endif ?>
                    <label class="form-check-label" for="recurent">
                        Recurrent
                    </label>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" name="editProduct" value="Valider">
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