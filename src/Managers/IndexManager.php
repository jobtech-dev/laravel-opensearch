<?php

namespace Jobtech\Support\OpenSearch\Managers;

use OpenSearch\Client;
use Illuminate\Support\Arr;
use Jobtech\Support\OpenSearch\Contracts\Index;
use Jobtech\Support\OpenSearch\Events\IndexClosed;
use Jobtech\Support\OpenSearch\Events\IndexOpened;
use Jobtech\Support\OpenSearch\Helpers\Contracts\PrefixHelper;
use Jobtech\Support\OpenSearch\Managers\Contracts\IndexManager as IndexManagerContract;

class IndexManager implements IndexManagerContract
{
    public function __construct(
        private readonly Client $client,
        private readonly PrefixHelper $prefixHelper,
    ) {}

    public function existsIndex(Index $index): bool
    {
        return $this->client->indices()->exists([
            'index' => $this->prefixHelper->parseIndex($index->name()),
        ]);
    }

    public function getIndex(Index $index): array
    {
        return $this->client->indices()->get([
            'index' => $this->prefixHelper->parseIndex($index->name()),
        ]);
    }

    public function createIndex(Index $index): array
    {
        $body = ['mappings' => $index->mappings()];

        if (count($index->settings())) {
            $body['settings'] = $index->settings();
        }

        return $this->client->indices()->create([
            'index' => $this->prefixHelper->parseIndex($index->name()),
            'body' => $body,
        ]);
    }

    public function putIndexSettings(Index $index): array
    {
        return $this->closeOpenCallback($index, fn (Index $index) => $this->client->indices()->putSettings([
            'index' => $this->prefixHelper->parseIndex($index->name()),
            'body' => $index->settings(),
        ]));
    }

    public function putIndexMappings(Index $index): array
    {
        return $this->closeOpenCallback($index, fn (Index $index) => $this->client->indices()->putMapping([
            'index' => $this->prefixHelper->parseIndex($index->name()),
            'body' => $index->mappings(),
        ]));
    }

    public function deleteIndex(Index $index): array
    {
        return $this->client->indices()->delete([
            'index' => $this->prefixHelper->parseIndex($index->name()),
        ]);
    }

    public function openIndex(Index $index): array
    {
        $response = $this->client->indices()->open([
            'index' => $this->prefixHelper->parseIndex($index->name()),
        ]);

        if (Arr::get($response, 'acknowledged', false)) {
            event(new IndexOpened($index));
        }

        return $response;
    }

    public function closeIndex(Index $index): array
    {
        $response = $this->client->indices()->close([
            'index' => $this->prefixHelper->parseIndex($index->name()),
        ]);

        if (Arr::get($response, 'acknowledged', false)) {
            event(new IndexClosed($index));
        }

        return $response;
    }

    public function closeOpenCallback(Index $index, \Closure $closure): array
    {
        $this->closeIndex($index);

        try {
            return $closure($index);
        } finally {
            $this->openIndex($index);
        }
    }
}
