<h1>Home</h1>
<?php

use App\Core\Helpers\Session;

if (!is_null(Session::getMessage())) : ?>
    <?php var_dump(Session::getMessage()) ?>
    <?php Session::unset('msg'); ?>
<?php endif; ?>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Stock Actuel</th>
            <th scope="col">Stock Minimale</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) : ?>
            <tr>
                <th scope="row"><?= $product->id_products ?></th>
                <td><?= $product->name ?></td>
                <td><?= $product->stock_actual ?></td>
                <td><?= $product->stock_min ?></td>
                <td><?= $product->recurrent ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>