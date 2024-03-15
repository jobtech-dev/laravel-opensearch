<?php

namespace Jobtech\Support\OpenSearch\Managers\Contracts;

interface DocumentManager
{
    public function retrieveDocument(string $index, string $id): array;

    public function createDocument(string $index, string $id, array $body, bool $refresh = true): array;

    public function createDocumentWithoutId(string $index, array $body, bool $refresh = true): array;

    public function createDocumentFrom(array $params): array;

    public function updateDocument(string $index, string $id, array $body, bool $refresh = true): array;

    public function upsertDocument(string $index, string $id, array $body, bool $refresh = true): array;

    public function deleteDocument(string $index, string $id): array;

    public function countDocument(string $index, ?array $body = []): array;
}
