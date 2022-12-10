<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Magasins pour le produit : <?= $singleProduct->name ?></h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-6">
            <form method="POST">
                <div class="mb-3">
                    <select name="store" class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <?php foreach ($allStores as $store) : ?>
                            <option value="<?= $store->id_stores ?>"><?= $store->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix pour ce magasin : </label>
                        <input type="number" step="0.01" class="form-control" name="price" <?= isset($_POST['price']) ? 'value="' . htmlspecialChars($_POST['price']) . '"' : '' ?>>
                    </div>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" name="addStoreToProduct" value="Valider">
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