<?php

namespace Jobtech\Support\Opensearch\Tests\Unit\Managers;

use OpenSearch\Client;
use Mockery\MockInterface;
use Jobtech\Support\Opensearch\Tests\TestCase;
use Jobtech\Support\Opensearch\Managers\Contracts\SearchManager;

/**
 * @internal
 */
class SearchManagerTest extends TestCase
{
    public function testSearch(): void
    {
        $expected = ['index' => 'dummy-prefix_foo'];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('search')->once()->with($expected)->andReturn([
                'took' => 23,
                'timed_out' => false,
                '_shards' => [
                    'total' => 1,
                    'successful' => 1,
                    'skipped' => 0,
                    'failed' => 0,
                ],
                'hits' => [
                    'total' => [
                        'value' => 1,
                        'relation' => 'eq',
                    ],
                    'max_score' => 0.2876821,
                    'hits' => [
                        [
                            '_index' => 'dummy-prefix_foo',
                            '_id' => 'foo',
                            '_score' => 0.2876821,
                            '_source' => [
                                'updatedAt' => '2023-12-05 18:44:47',
                            ],
                        ],
                    ],
                ],
            ]);
        });

        /** @var SearchManager $manager */
        $manager = $this->app->make(SearchManager::class);

        $manager->search('foo');
    }

    public function testSearchWithPagination(): void
    {
        $expected = [
            'index' => 'dummy-prefix_foo',
            'size' => 10,
            'from' => 0,
        ];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('search')->once()->with($expected)->andReturn([
                'took' => 23,
                'timed_out' => false,
                '_shards' => [
                    'total' => 1,
                    'successful' => 1,
                    'skipped' => 0,
                    'failed' => 0,
                ],
                'hits' => [
                    'total' => [
                        'value' => 2,
                        'relation' => 'eq',
                    ],
                    'max_score' => 1.0,
                    'hits' => [
                        [
                            '_index' => 'dummy-prefix_foo',
                            '_id' => 'foo',
                            '_score' => 0.2876821,
                            '_source' => [
                                'updatedAt' => '2023-12-05 18:44:47',
                            ],
                        ],
                    ],
                ],
            ]);
        });

        /** @var SearchManager $manager */
        $manager = $this->app->make(SearchManager::class);

        $manager->searchWithPagination('foo', 1, 10);
    }
}
