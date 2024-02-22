<?php

namespace Jobtech\Support\Opensearch\Managers\Contracts;

use Jobtech\Support\Opensearch\Contracts\Index;

interface IndicesManager
{
    public function existsIndex(Index $index): bool;

    public function getIndex(Index $index): array;

    public function createIndex(Index $index): array;

    public function updateIndexSettings(Index $index): array;

    public function updateIndexMappings(Index $index): array;

    public function deleteIndex(Index $index): array;

    public function openIndex(Index $index): array;

    public function closeIndex(Index $index): array;
}
