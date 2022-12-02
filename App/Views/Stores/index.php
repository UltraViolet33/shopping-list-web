<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Tous les magasins</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allStores as $store) : ?>
                        <tr>
                            <td><?= $store->name ?></td>
                            <td><a href="/stores/edit?id=<?= $store->id_stores ?>">Modifier</a></td>
                            <td><a >Supprimer</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>