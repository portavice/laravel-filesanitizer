<?php

namespace Portavice\LaravelFileSanitizer\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Portavice\LaravelFileSanitizer\FileSanitizerServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [FileSanitizerServiceProvider::class];
    }
}
