<?php var_dump($singleProduct); ?>
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
                        <th><?= $singleProduct->stock_actual ?></th>
                        <th><?= $singleProduct->stock_min ?></th>
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
                        </tr>
                    </thead>
                    <?php foreach ($storesProduct as $store) : ?>
                        <tr>
                            <th><?= $store->name ?></th>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>Pas de magasins enregistré pour ce produit</p>
            <?php endif; ?>
        </div>
    </div>
</div>