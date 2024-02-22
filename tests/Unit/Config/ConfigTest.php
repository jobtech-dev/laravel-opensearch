<?php

namespace Jobtech\Support\Opensearch\Tests\Unit\Config;

use Mockery\MockInterface;
use Jobtech\Support\Opensearch\Tests\TestCase;
use Jobtech\Support\Opensearch\Contracts\Index;
use Jobtech\Support\Opensearch\Config\Contracts\Config;

/**
 * @internal
 */
class ConfigTest extends TestCase
{
    public function testReturnIndices(): void
    {
        config(['opensearch' => [
            'indices' => ['foo', 'bar'],
        ]]);

        /** @var Config $config */
        $config = $this->app->make(Config::class);

        $this->assertEquals(['foo', 'bar'], $config->indices());
    }

    public function testReturnResolvedIndex(): void
    {
        $this->mock(Config::class, function (MockInterface $mock) {
            $mock->allows('resolveIndex')->once()->with('foo')->andReturn($this->createStub(Index::class));
        });

        /** @var Config $config */
        $config = $this->app->make(Config::class);
        $config->resolveIndex('foo');
    }

    public function testReturnResolvedPrefix(): void
    {
        config(['opensearch' => [
            'prefix' => 'foo',
        ]]);

        $this->mock(Config::class, function (MockInterface $mock) {
            $mock->allows('resolvePrefix')->once()->andReturn('foo');
        });

        /** @var Config $config */
        $config = $this->app->make(Config::class);
        $res = $config->resolvePrefix();

        $this->assertEquals('foo', $res);
    }
}
