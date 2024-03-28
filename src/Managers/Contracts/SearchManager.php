<?php

namespace Jobtech\Support\OpenSearch\Managers\Contracts;

interface SearchManager
{
    public function search(string $index, ?array $params = []): array;

    public function searchWithPagination(string $index, int $page, int $perPage, ?array $params = []): array;
}
