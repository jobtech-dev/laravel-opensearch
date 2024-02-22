<?php

namespace Jobtech\Support\Opensearch\Managers;

use OpenSearch\Client;
use Jobtech\Support\Opensearch\Helpers\Contracts\PrefixHelper;
use Jobtech\Support\Opensearch\Managers\Contracts\DocumentManager as DocumentManagerContract;

class DocumentManager implements DocumentManagerContract
{
    public function __construct(
        private readonly Client $client,
        private readonly PrefixHelper $prefixHelper,
    ) {}

    public function retrieveDocument(string $index, string $id): array
    {
        return $this->client->get([
            'index' => $this->prefixHelper->parseIndex($index),
            'id' => $id,
        ]);
    }

    public function createDocument(string $index, string $id, array $body, bool $refresh = true): array
    {
        return $this->createDocumentFrom([
            'index' => $this->prefixHelper->parseIndex($index),
            'id' => $id,
            'body' => $body,
            'refresh' => $refresh,
        ]);
    }

    public function createDocumentWithoutId(string $index, array $body, bool $refresh = true): array
    {
        return $this->createDocumentFrom([
            'index' => $this->prefixHelper->parseIndex($index),
            'body' => $body,
            'refresh' => $refresh,
        ]);
    }

    public function createDocumentFrom(array $params): array
    {
        return $this->client->create($params);
    }

    public function updateDocument(string $index, string $id, array $body, bool $refresh = true): array
    {
        return $this->client->update([
            'index' => $this->prefixHelper->parseIndex($index),
            'id' => $id,
            'body' => $body,
            'refresh' => $refresh,
        ]);
    }

    public function upsertDocument(string $index, string $id, array $body, bool $refresh = true): array
    {
        $body['doc_as_upsert'] = true;

        return $this->updateDocument($index, $id, $body, $refresh);
    }

    public function deleteDocument(string $index, string $id): array
    {
        return $this->client->delete([
            'index' => $this->prefixHelper->parseIndex($index),
            'id' => $id,
        ]);
    }

    public function countDocument(string $index, ?array $body = []): array
    {
        return $this->client->count([
            'index' => $this->prefixHelper->parseIndex($index),
            'body' => $body,
        ]);
    }
}
