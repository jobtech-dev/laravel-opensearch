<?php

namespace Jobtech\Support\OpenSearch\Managers\Contracts;

use Jobtech\Support\OpenSearch\Contracts\Index;

interface IndexManager
{
    public function existsIndex(Index $index): bool;

    public function getIndex(Index $index): array;

    public function createIndex(Index $index): array;

    public function putIndexSettings(Index $index): array;

    public function putIndexMappings(Index $index): array;

    public function deleteIndex(Index $index): array;

    public function openIndex(Index $index): array;

    public function closeIndex(Index $index): array;
}
