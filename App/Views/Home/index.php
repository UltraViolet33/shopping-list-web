<?php

use App\Core\Helpers\Session;

if (!is_null(Session::getMessage())) : ?>
    <?php Session::unset('msg'); ?>
<?php endif; ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Tous les produits</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-10">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Actuel</th>
                        <th scope="col">Min</th>
                        <th scope="col">Détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <?php
                        $class = "";
                        if ($product->stock_actual <= $product->stock_min) {
                            $class = "bg-danger";
                        }
                        ?>
                        <tr>
                            <td><?= $product->name ?></td>
                            <td class='<?= $class ?>'><button type="button" class="btn btn-warning">-</button>
                                <?= $product->stock_actual  ?>
                                <button type="button" class="btn btn-primary">+</button>
                            </td>
                            <td><?= $product->stock_min ?></td>
                            <td><button type="button" class="btn btn-secondary">Détails</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="assets/js/updateStock.js"></script>