<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Liste de courses</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-10 col-md-10">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Combien ? </th>
                    </tr>
                </thead>
                <tbody id="tableProducts">
                    <?php if (isset($productsHTML)) : ?>
                        <?= $productsHTML ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>