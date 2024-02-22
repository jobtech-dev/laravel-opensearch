<?php

namespace Jobtech\Support\Opensearch\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Jobtech\Support\Opensearch\JtOpensearchServiceProvider;

/**
 * @internal
 */
class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            JtOpensearchServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('opensearch', [
            'client' => [
                'hosts' => [
                    'host' => 'foo',
                ],
                'basicAuthentication' => ['opensearch', 'secret'],
            ],
            'indices' => [],
            'queue' => [
                'connection' => 'baz',
                'queue' => 'bar',
            ],
            'prefix' => 'dummy-prefix',
        ]);
    }
}
