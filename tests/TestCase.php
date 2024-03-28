<?php

namespace Jobtech\Support\OpenSearch\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Jobtech\Support\OpenSearch\JtOpenSearchServiceProvider;

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
            JtOpenSearchServiceProvider::class,
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
