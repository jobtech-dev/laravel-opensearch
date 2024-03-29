<?php

namespace Jobtech\Support\OpenSearch\Managers;

use OpenSearch\Client;
use Jobtech\Support\OpenSearch\Helpers\Contracts\PrefixHelper;
use Jobtech\Support\OpenSearch\Managers\Contracts\SearchManager as SearchManagerContract;

class SearchManager implements SearchManagerContract
{
    public function __construct(
        private readonly Client $client,
        private readonly PrefixHelper $prefixHelper,
    ) {}

    public function search(string $index, ?array $params = []): array
    {
        $params['index'] = $this->prefixHelper->parseIndex($index);

        return $this->client->search($params);
    }

    public function searchWithPagination(string $index, int $page, int $perPage, ?array $params = []): array
    {
        $params['from'] = ($page * $perPage) - $perPage;
        $params['size'] = $perPage;

        return $this->search($index, $params);
    }
}
