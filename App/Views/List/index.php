<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Liste de courses</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-6">
            <form method="POST">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Acheter ?</th>
                            <th scope="col">Produit</th>
                            <th scope="col">Nombre</th>
                        </tr>
                    </thead>
                    <tbody id="tableProducts">
                    </tbody>
                </table>
                <button class="btn btn-primary" type="submit">Afficher les magasins</button>
            </form>
        </div>
        <div class="row justify-content-center my-3">
            <div class="col-10 col-md-6" id="stores">
            </div>
        </div>
    </div>
</div>
<script src="assets/js/list.js"></script>