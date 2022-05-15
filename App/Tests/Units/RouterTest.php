<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Router\Router;

class RouterTest extends TestCase
{

    /** @test*/
    public function it_registers_get_routes(): void
    {
        $router = new Router();
        $router->get('/', ["App/Controllers/HomeController", 'index']);

        $this->assertEquals(
            ["GET" => ['/' => ["App/Controllers/HomeController", "index"]]],
            $router->getRoutes()
        );
    }

    /** @test*/
    public function it_registers_post_routes(): void
    {
        $router = new Router();
        $router->post('/', ["App/Controllers/HomeController", 'index']);

        $this->assertEquals(
            ["POST" => ['/' => ["App/Controllers/HomeController", "index"]]],
            $router->getRoutes()
        );
    }

    /** @test */
    public function it_doesnt_have_any_routes_before_registering_routes(): void
    {
        $router = new Router();
        $this->assertEmpty($router->getRoutes());
    }
}
