<?php

namespace Jobtech\Support\OpenSearch\Tests\Unit\Managers;

use OpenSearch\Client;
use Mockery\MockInterface;
use Illuminate\Support\Arr;
use OpenSearch\Namespaces\IndicesNamespace;
use Jobtech\Support\OpenSearch\Tests\TestCase;
use Jobtech\Support\OpenSearch\Contracts\Index;
use Jobtech\Support\OpenSearch\Managers\Contracts\IndexManager;

/**
 * @internal
 */
class IndexManagerTest extends TestCase
{
    public function testExistsIndex(): void
    {
        $index = new class() implements Index {
            public function name(): string
            {
                return 'foo';
            }

            public function mappings(): array
            {
                return [];
            }

            public function settings(): array
            {
                return [];
            }

            public function aliases(): array
            {
                return [];
            }
        };

        $expected = [
            'index' => 'dummy-prefix_foo',
        ];

        $indices = $this->mock(IndicesNamespace::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('exists')->once()->with($expected)->andReturn(true);
        });

        $this->mock(Client::class, function (MockInterface $mock) use ($indices) {
            $mock->allows('indices')->once()->andReturn($indices);
        });

        /** @var IndexManager $manager */
        $manager = $this->app->make(IndexManager::class);

        $manager->existsIndex($index);
    }

    public function testCreateIndex(): void
    {
        $index = new class() implements Index {
            public function name(): string
            {
                return 'foo';
            }

            public function mappings(): array
            {
                return ['bar'];
            }

            public function settings(): array
            {
                return ['baz'];
            }

            public function aliases(): array
            {
                return [];
            }
        };

        $expected = [
            'index' => 'dummy-prefix_foo',
            'body' => [
                'mappings' => ['bar'],
                'settings' => ['baz'],
            ],
        ];

        $indices = $this->mock(IndicesNamespace::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('create')->once()->with($expected)->andReturn(['acknowledged' => true]);
        });

        $this->mock(Client::class, function (MockInterface $mock) use ($indices) {
            $mock->allows('indices')->once()->andReturn($indices);
        });

        /** @var IndexManager $manager */
        $manager = $this->app->make(IndexManager::class);

        $manager->createIndex($index);
    }

    public function testUpdateIndexSettings(): void
    {
        $index = new class() implements Index {
            public function name(): string
            {
                return 'foo';
            }

            public function mappings(): array
            {
                return ['bar'];
            }

            public function settings(): array
            {
                return ['baz'];
            }

            public function aliases(): array
            {
                return [];
            }
        };

        $expected = [
            'index' => 'dummy-prefix_foo',
            'body' => ['baz'],
        ];

        $indices = $this->mock(IndicesNamespace::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('close')->once()->with(Arr::only($expected, 'index'))->andReturn([
                'acknowledged' => true,
                'shards_acknowledged' => true,
                'indices' => [
                    'sample-index1' => [
                        'closed' => true,
                    ],
                ],
            ]);
            $mock->allows('putSettings')->once()->with($expected)->andReturn(['acknowledged' => true]);
            $mock->allows('open')->once()->with(Arr::only($expected, 'index'))->andReturn([
                'acknowledged' => true,
                'shards_acknowledged' => true,
                'indices' => [
                    'sample-index1' => [
                        'opened' => true,
                    ],
                ],
            ]);
        });

        $this->mock(Client::class, function (MockInterface $mock) use ($indices) {
            $mock->allows('indices')->times(3)->andReturn($indices);
        });

        /** @var IndexManager $manager */
        $manager = $this->app->make(IndexManager::class);

        $manager->updateIndexSettings($index);
    }

    public function testUpdateIndexMappings(): void
    {
        $index = new class() implements Index {
            public function name(): string
            {
                return 'foo';
            }

            public function mappings(): array
            {
                return ['bar'];
            }

            public function settings(): array
            {
                return ['baz'];
            }

            public function aliases(): array
            {
                return [];
            }
        };

        $expected = [
            'index' => 'dummy-prefix_foo',
            'body' => ['bar'],
        ];

        $indices = $this->mock(IndicesNamespace::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('close')->once()->with(Arr::only($expected, 'index'))->andReturn([
                'acknowledged' => true,
                'shards_acknowledged' => true,
                'indices' => [
                    'sample-index1' => [
                        'closed' => true,
                    ],
                ],
            ]);
            $mock->allows('putMapping')->once()->with($expected)->andReturn(['acknowledged' => true]);
            $mock->allows('open')->once()->with(Arr::only($expected, 'index'))->andReturn([
                'acknowledged' => true,
                'shards_acknowledged' => true,
                'indices' => [
                    'sample-index1' => [
                        'opened' => true,
                    ],
                ],
            ]);
        });

        $this->mock(Client::class, function (MockInterface $mock) use ($indices) {
            $mock->allows('indices')->times(3)->andReturn($indices);
        });

        /** @var IndexManager $manager */
        $manager = $this->app->make(IndexManager::class);

        $manager->updateIndexMappings($index);
    }

    public function testDeleteIndex(): void
    {
        $index = new class() implements Index {
            public function name(): string
            {
                return 'foo';
            }

            public function mappings(): array
            {
                return ['bar'];
            }

            public function settings(): array
            {
                return ['baz'];
            }

            public function aliases(): array
            {
                return [];
            }
        };

        $expected = [
            'index' => 'dummy-prefix_foo',
        ];

        $indices = $this->mock(IndicesNamespace::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('delete')->once()->with($expected)->andReturn(['acknowledged' => true]);
        });

        $this->mock(Client::class, function (MockInterface $mock) use ($indices) {
            $mock->allows('indices')->once()->andReturn($indices);
        });

        /** @var IndexManager $manager */
        $manager = $this->app->make(IndexManager::class);

        $manager->deleteIndex($index);
    }

    public function testOpenIndex(): void
    {
        $index = new class() implements Index {
            public function name(): string
            {
                return 'foo';
            }

            public function mappings(): array
            {
                return ['bar'];
            }

            public function settings(): array
            {
                return ['baz'];
            }

            public function aliases(): array
            {
                return [];
            }
        };

        $expected = [
            'index' => 'dummy-prefix_foo',
        ];

        $indices = $this->mock(IndicesNamespace::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('open')->once()->with($expected)->andReturn([
                'acknowledged' => true,
                'shards_acknowledged' => true,
                'indices' => [
                    'sample-index1' => [
                        'opened' => true,
                    ],
                ],
            ]);
        });

        $this->mock(Client::class, function (MockInterface $mock) use ($indices) {
            $mock->allows('indices')->once()->andReturn($indices);
        });

        /** @var IndexManager $manager */
        $manager = $this->app->make(IndexManager::class);

        $manager->openIndex($index);
    }

    public function testCloseIndex(): void
    {
        $index = new class() implements Index {
            public function name(): string
            {
                return 'foo';
            }

            public function mappings(): array
            {
                return ['bar'];
            }

            public function settings(): array
            {
                return ['baz'];
            }

            public function aliases(): array
            {
                return [];
            }
        };

        $expected = [
            'index' => 'dummy-prefix_foo',
        ];

        $indices = $this->mock(IndicesNamespace::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('close')->once()->with($expected)->andReturn([
                'acknowledged' => true,
                'shards_acknowledged' => true,
                'indices' => [
                    'sample-index1' => [
                        'closed' => true,
                    ],
                ],
            ]);
        });

        $this->mock(Client::class, function (MockInterface $mock) use ($indices) {
            $mock->allows('indices')->once()->andReturn($indices);
        });

        /** @var IndexManager $manager */
        $manager = $this->app->make(IndexManager::class);

        $manager->closeIndex($index);
    }
}
