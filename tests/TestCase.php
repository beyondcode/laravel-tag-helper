<?php

namespace BeyondCode\TagHelper\Tests;

use BeyondCode\TagHelper\TagHelper;
use Illuminate\Support\Facades\Blade;
use Spatie\Snapshots\MatchesSnapshots;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase as Orchestra;
use BeyondCode\TagHelper\TagHelperServiceProvider;

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

        $this->assertMatchesSnapshot(
            view($fullViewName, $data)->render()
        );

        $this->assertMatchesSnapshot(
            '<div>'.Blade::compileString($this->getViewContents($viewName)).'</div>'
        );
    }

    protected function getViewContents(string $viewName): string
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

        $testFile = last($backtrace)['file'];

        $baseDirectory = pathinfo($testFile, PATHINFO_DIRNAME);

        $viewFileName = "{$baseDirectory}/stubs/views/{$viewName}.blade.php";

        return file_get_contents($viewFileName);
    }
}
