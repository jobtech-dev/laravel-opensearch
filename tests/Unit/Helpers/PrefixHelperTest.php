<?php

namespace Jobtech\Support\Opensearch\Tests\Unit\Helpers;

use Mockery\MockInterface;
use Jobtech\Support\Opensearch\Tests\TestCase;
use Jobtech\Support\Opensearch\Config\Contracts\Config;
use Jobtech\Support\Opensearch\Helpers\Contracts\PrefixHelper;

/**
 * @internal
 */
class PrefixHelperTest extends TestCase
{
    public function testParseIndexConfigNull(): void
    {
        $this->mock(Config::class, function (MockInterface $mock) {
            $mock->allows('resolvePrefix')->once()->andReturn(null);
        });

        /** @var PrefixHelper $prefixHelper */
        $prefixHelper = $this->app->make(PrefixHelper::class);

        $res = $prefixHelper->parseIndex('foo');

        $this->assertEquals('foo', $res);
    }

    public function testParseIndex(): void
    {
        config(['opensearch' => [
            'prefix' => 'foo',
        ]]);

        $this->mock(Config::class, function (MockInterface $mock) {
            $mock->allows('resolvePrefix')->once()->andReturn('foo');
        });

        /** @var PrefixHelper $prefixHelper */
        $prefixHelper = $this->app->make(PrefixHelper::class);

        $res = $prefixHelper->parseIndex('bar');

        $this->assertEquals('foo_bar', $res);
    }
}
