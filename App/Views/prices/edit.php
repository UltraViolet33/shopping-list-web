<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Edit price for product : <?= $product->name ?> in store : <?= $store->name ?></h1>
        </div>
    </div>
    <div class="row justify-content-center my-5">
        <div class="col-10 col-md-6">
            <form method="POST">
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix pour ce magasin : </label>
                        <input type="number" step="0.01" class="form-control" name="price" value="<?= $price->amount ?>">
                    </div>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" value="Valider">
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