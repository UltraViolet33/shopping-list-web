<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Détails du produit <?= $singleProduct->name ?></h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-10">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Stock Actuel</th>
                        <th scope="col">Stock Min</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th><?= $singleProduct->name ?></th>
                        <th><?= $singleProduct->stock_actual ?? "produit récurrent" ?></th>
                        <th><?= $singleProduct->stock_min ?? "produit récurrent" ?></th>
                        <th><button class="btn btn-primary">Modifier</button></th>
                        <th><button class="btn btn-danger">Supprimer</button></th>
                    </tr>
                </tbody>
            </table>
            <?php if ($storesProduct) : ?>
                <h3>Magasins</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Modifier</th>
                        </tr>
                    </thead>
                    <?php foreach ($storesProduct as $store) : ?>
                        <tr>
                            <th><?= $store->name ?></th>
                            <th><?= $store->amount ?> €</th>
                            <th><a href="/product/store/edit?idproduct=<?= $singleProduct->id_product ?>&idstore=<?= $store->id_store ?>" class="btn btn-primary">Modifier</a></th>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>Pas de magasins enregistré pour ce produit</p>
            <?php endif; ?>
            <div>
                <a href="/product/addStore?id=<?= $singleProduct->id_product ?>" class="btn btn-primary">Ajouter un magasin</a>
            </div>
        </div>
    </div>
</div>