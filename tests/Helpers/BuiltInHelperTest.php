<?php

namespace BeyondCode\TagHelper\Tests\Helpers;

use Illuminate\Support\Facades\View;
use BeyondCode\TagHelper\Tests\TestCase;

class BuiltInHelperTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        View::addLocation(__DIR__.'/stubs');
    }

    /** @test */
    public function it_appends_csrf_fields_to_forms()
    {
        $this->assertPhpMatchesViewSnapshot('form_csrf');
    }

    /** @test */
    public function it_modifies_form_methods()
    {
        $this->assertPhpMatchesViewSnapshot('form_method');
    }

    /** @test */
    public function it_generates_links()
    {
        \Route::name('some_route')->get('/some_route', function() {});

        $this->assertPhpMatchesViewSnapshot('link_to_route');
    }

    /** @test */
    public function it_generates_links_with_route_parameters()
    {
        \Route::name('route_with_parameters')->get('/route/{a}/{b}', function() {});

        $this->assertPhpMatchesViewSnapshot('link_to_route_with_parameters');
    }

}