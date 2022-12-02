<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Ajouter un magasin</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-6">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du magasin : </label>
                    <input type="text" class="form-control" name="name" <?= isset($_POST['name']) ? 'value="' . htmlspecialChars($_POST['name']) . '"' : '' ?>>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary" name="createStore" value="Valider">
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