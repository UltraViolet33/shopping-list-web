<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Liste de courses</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-6">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Name</th>
                        <th scope="col">Nombre</th>
                    </tr>
                </thead>
                <tbody id="tableProducts">
                    <?php if (isset($products)) : ?>
                        <?= $products[0] ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <h4>Nombre d'articles à acheter : <?= $products[1] ?></h4>
        </div>
    </div>
</div>