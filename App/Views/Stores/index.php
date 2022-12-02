<div class="container my-3">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Tous les magasins</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-10">
            <table class="table">
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
                            <td><a href="">Modifier</a></td>
                            <td><a href="">Supprimer</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>