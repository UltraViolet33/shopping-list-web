<h1>Home</h1>
<?php

use App\Core\Helpers\Session;

 if (!is_null(Session::getMessage())) : ?>
    <?php var_dump(Session::getMessage()) ?>
    <?php Session::unset('msg'); ?>
<?php endif; ?>