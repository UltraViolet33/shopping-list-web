<h1>Home</h1>
<?php

use App\Core\Helpers\Session;

 if (isset($msg)) : ?>
    <?= $msg ?>
    <?php Session::unset('msg'); ?>
<?php endif; ?>