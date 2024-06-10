<?php

namespace Jobtech\Support\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method array search(string $index, ?array $params = [])
 * @method array searchWithPagination(string $index, int $page, int $perPage, ?array $params = [])
 *
 * @see \Jobtech\Support\OpenSearch\Managers\Contracts\SearchManager
 */
class SearchManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'open-search-search-manager';
    }
}
