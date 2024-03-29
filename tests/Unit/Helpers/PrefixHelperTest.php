<?php

namespace Jobtech\Support\OpenSearch\Tests\Unit\Helpers;

use Mockery\MockInterface;
use Jobtech\Support\OpenSearch\Tests\TestCase;
use Jobtech\Support\OpenSearch\Config\Contracts\Config;
use Jobtech\Support\OpenSearch\Helpers\Contracts\PrefixHelper;

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
