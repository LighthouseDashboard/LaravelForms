<?php


namespace Tests;


use Lighthouse\Laravel\Forms\FormsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            FormsServiceProvider::class
        ];
    }

}
