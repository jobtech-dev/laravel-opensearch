<?php

namespace Jobtech\Support\OpenSearch\Tests\Unit\Managers;

use OpenSearch\Client;
use Mockery\MockInterface;
use Jobtech\Support\OpenSearch\Tests\TestCase;
use Jobtech\Support\OpenSearch\Managers\Contracts\SearchManager;
use Jobtech\Support\OpenSearch\Managers\Contracts\DocumentManager;

/**
 * @internal
 */
class DocumentManagerTest extends TestCase
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

    public function testRetrieveDocument(): void
    {
        $expected = [
            'index' => 'dummy-prefix_foo',
            'id' => 'bar',
        ];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('get')->once()->with($expected)->andReturn([
                '_index' => 'dummy-prefix_foo',
                '_id' => 'bar',
                '_version' => 1,
                '_seq_no' => 0,
                '_primary_term' => 9,
                'found' => true,
                '_source' => [
                    'text' => 'This is just some sample text.',
                ],
            ]);
        });

        /** @var DocumentManager $manager */
        $manager = $this->app->make(DocumentManager::class);

        $manager->retrieveDocument('foo', 'bar');
    }

    public function testCreateDocument(): void
    {
        $expected = [
            'index' => 'dummy-prefix_foo',
            'id' => 'bar',
            'refresh' => false,
            'body' => ['baz'],
        ];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('create')->once()->with($expected)->andReturn([
                '_index' => 'dummy-prefix_foo',
                '_id' => 'bar',
                '_version' => 1,
                'result' => 'created',
                '_shards' => [
                    'total' => 2,
                    'successful' => 1,
                    'failed' => 0,
                ],
                '_seq_no' => 0,
                '_primary_term' => 9,
            ]);
        });

        /** @var DocumentManager $manager */
        $manager = $this->app->make(DocumentManager::class);

        $manager->createDocument('foo', 'bar', ['baz'], false);
    }

    public function testCreateDocumentWithoutId(): void
    {
        $expected = [
            'index' => 'dummy-prefix_foo',
            'refresh' => false,
            'body' => ['baz'],
        ];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('create')->once()->with($expected)->andReturn([
                '_index' => 'dummy-prefix_foo',
                '_id' => 'id_created',
                '_version' => 1,
                'result' => 'created',
                '_shards' => [
                    'total' => 2,
                    'successful' => 1,
                    'failed' => 0,
                ],
                '_seq_no' => 0,
                '_primary_term' => 9,
            ]);
        });

        /** @var DocumentManager $manager */
        $manager = $this->app->make(DocumentManager::class);

        $manager->createDocumentWithoutId('foo', ['baz'], false);
    }

    public function testCreateDocumentFrom(): void
    {
        $expected = [
            'index' => 'dummy-prefix_foo',
            'id' => 'bar',
            'refresh' => false,
            'body' => ['baz'],
        ];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('create')->once()->with($expected)->andReturn([
                '_index' => 'dummy-prefix_foo',
                '_id' => 'bar',
                '_version' => 1,
                'result' => 'created',
                '_shards' => [
                    'total' => 2,
                    'successful' => 1,
                    'failed' => 0,
                ],
                '_seq_no' => 0,
                '_primary_term' => 9,
            ]);
        });

        /** @var DocumentManager $manager */
        $manager = $this->app->make(DocumentManager::class);

        $manager->createDocumentFrom($expected);
    }

    public function testUpdateDocument(): void
    {
        $expected = [
            'index' => 'dummy-prefix_foo',
            'id' => 'bar',
            'refresh' => false,
            'body' => ['baz'],
        ];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('update')->once()->with($expected)->andReturn([
                '_index' => 'dummy-prefix_foo',
                '_id' => 'bar',
                '_version' => 2,
                'result' => 'updated',
                '_shards' => [
                    'total' => 2,
                    'successful' => 1,
                    'failed' => 0,
                ],
                '_seq_no' => 0,
                '_primary_term' => 9,
            ]);
        });

        /** @var DocumentManager $manager */
        $manager = $this->app->make(DocumentManager::class);

        $manager->updateDocument('foo', 'bar', ['baz'], false);
    }

    public function testUpsertDocument(): void
    {
        $expected = [
            'index' => 'dummy-prefix_foo',
            'id' => 'bar',
            'body' => [
                'baz' => 'foo',
                'doc_as_upsert' => true,
            ],
            'refresh' => false,
        ];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('update')->once()->with($expected)->andReturn([
                '_index' => 'dummy-prefix_foo',
                '_id' => 'bar',
                '_version' => 3,
                'result' => 'updated',
                '_shards' => [
                    'total' => 2,
                    'successful' => 1,
                    'failed' => 0,
                ],
                '_seq_no' => 0,
                '_primary_term' => 9,
            ]);
        });

        /** @var DocumentManager $manager */
        $manager = $this->app->make(DocumentManager::class);

        $manager->upsertDocument('foo', 'bar', ['baz' => 'foo', 'doc_as_upsert' => true], false);
    }

    public function testDeleteDocument(): void
    {
        $expected = [
            'index' => 'dummy-prefix_foo',
            'id' => 'bar',
        ];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('delete')->once()->with($expected)->andReturn([
                '_index' => 'dummy-prefix_foo',
                '_id' => 'bar',
                '_version' => 3,
                'result' => 'deleted',
                '_shards' => [
                    'total' => 2,
                    'successful' => 1,
                    'failed' => 0,
                ],
                '_seq_no' => 1,
                '_primary_term' => 9,
            ]);
        });

        /** @var DocumentManager $manager */
        $manager = $this->app->make(DocumentManager::class);

        $manager->deleteDocument('foo', 'bar');
    }

    public function testCountDocument(): void
    {
        $expected = [
            'index' => 'dummy-prefix_foo',
            'body' => ['baz'],
        ];

        $this->mock(Client::class, function (MockInterface $mock) use ($expected) {
            $mock->allows('count')->once()->with($expected)->andReturn([
                'count' => 14074,
                '_shards' => [
                    'total' => 1,
                    'successful' => 1,
                    'skipped' => 0,
                    'failed' => 0,
                ],
            ]);
        });

        /** @var DocumentManager $manager */
        $manager = $this->app->make(DocumentManager::class);

        $manager->countDocument('foo', ['baz']);
    }
}
