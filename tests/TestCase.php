<?php

namespace BeyondCode\TagHelper\Tests;

use BeyondCode\TagHelper\TagHelper;
use Illuminate\Support\Facades\Blade;
use Spatie\Snapshots\MatchesSnapshots;
use Illuminate\Support\Facades\Artisan;
use BeyondCode\TagHelper\TagHelperServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use MatchesSnapshots;

    protected function setUp()
    {
        parent::setUp();

        Artisan::call('view:clear');
    }

    protected function getPackageProviders($app)
    {
        return [
            TagHelperServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'TagHelper' => TagHelper::class,
        ];
    }

    protected function assertMatchesViewSnapshot(string $viewName, array $data = [])
    {
        $fullViewName = "views.{$viewName}";

        $this->assertMatchesXmlSnapshot(
            view($fullViewName, $data)->render()
        );
    }

    protected function assertPhpMatchesViewSnapshot(string $viewName, array $data = [])
    {
        $fullViewName = "views.{$viewName}";

        $this->assertMatchesSnapshot(
            view($fullViewName, $data)->render()
        );
    }
}