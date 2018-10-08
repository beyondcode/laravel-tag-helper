<?php

namespace BeyondCode\TagHelper\Tests\Helpers;

use Illuminate\Support\Facades\Auth;
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
        $this->assertMatchesViewSnapshot('form_csrf');
    }

    /** @test */
    public function it_modifies_form_methods()
    {
        $this->assertMatchesViewSnapshot('form_method');
    }

    /** @test */
    public function it_generates_links()
    {
        \Route::name('some_route')->get('/some_route', function () {
        });

        $this->assertMatchesViewSnapshot('link_to_route');
    }

    /** @test */
    public function it_generates_links_with_route_parameters()
    {
        \Route::name('route_with_parameters')->get('/route/{a}/{b}', function () {
        });

        $this->assertMatchesViewSnapshot('link_to_route_with_parameters');
    }

    /** @test */
    public function it_checks_conditions_with_true_value()
    {
        $this->assertMatchesViewSnapshot('conditional', ['condition' => true]);
    }

    /** @test */
    public function it_checks_conditions_with_faulty_value()
    {
        $this->assertMatchesViewSnapshot('conditional', ['condition' => false]);
    }

    /** @test */
    public function it_performs_auth_checks()
    {
        $this->assertMatchesViewSnapshot('auth');
    }

    /** @test */
    public function it_performs_auth_checks_with_different_guards()
    {
        $this->assertMatchesViewSnapshot('auth_guard', ['guard' => 'web']);
    }

    /** @test */
    public function it_performs_guest_checks()
    {
        $this->assertMatchesViewSnapshot('guest');
    }

    /** @test */
    public function it_performs_guest_checks_with_different_guards()
    {
        $this->assertMatchesViewSnapshot('guest_guard', ['guard' => 'web']);
    }
}
