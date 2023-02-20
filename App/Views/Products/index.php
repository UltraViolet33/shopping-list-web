<?php

use App\Core\Helpers\Session;

if (!is_null(Session::getMessage())) : ?>
    <?php echo Session::getMessage(); ?>
    <?php Session::unset('msg'); ?>
<?php endif; ?>
<div class="container my-3">
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
                        <th scope="col">Nom</th>
                        <th scope="col">Stock Actuel</th>
                        <th scope="col">Stock Min</th>
                        <th scope="col">Details</th>
                        <th scope="col">Modifier</th>
                        <th scope="col">Supprimer</th>
                    </tr>
                </thead>
                <tbody id="tableProducts">
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="assets/js/indexProducts.js"></script>
<!-- <script src="assets/js/updateStock.js"></script> -->
