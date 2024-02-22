<?php

namespace Jobtech\Support\Opensearch\Managers;

use OpenSearch\Client;
use Illuminate\Support\Arr;
use Jobtech\Support\Opensearch\Contracts\Index;
use Jobtech\Support\Opensearch\Events\IndexClosed;
use Jobtech\Support\Opensearch\Events\IndexOpened;
use Jobtech\Support\Opensearch\Helpers\Contracts\PrefixHelper;
use Jobtech\Support\Opensearch\Managers\Contracts\IndicesManager as IndicesManagerContract;

class IndicesManager implements IndicesManagerContract
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

    public function updateIndexSettings(Index $index): array
    {
        return $this->closeOpenCallback($index, fn (Index $index) => $this->client->indices()->putSettings([
            'index' => $this->prefixHelper->parseIndex($index->name()),
            'body' => $index->settings(),
        ]));
    }

    public function updateIndexMappings(Index $index): array
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

    private function closeOpenCallback(Index $index, \Closure $closure): array
    {
        $this->closeIndex($index);

        try {
            return $closure($index);
        } finally {
            $this->openIndex($index);
        }
    }
}
