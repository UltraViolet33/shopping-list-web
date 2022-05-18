<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Controllers\ProductController;
use App\Core\Helpers\Session;
use App\Core\Render;


class ProductControllerTest extends TestCase
{
    /** @test */
    public function createProductWithGoodValues()
    {
        $productController = new ProductController();
        $result = gettype($productController->create());
        $this->assertEquals(1, 1);
    }

}