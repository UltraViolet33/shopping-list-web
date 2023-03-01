<?php

namespace App\Models;

use App\Core\Database\Database;
use stdClass;

class Price extends Model
{
    
    public function create(array $data): bool
    {
        return true;
    }

    public function update(array $data): bool
    {
        return true;
    }
}
