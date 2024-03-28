<?php

namespace Jobtech\Support\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;

class SearchManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'open-search-search-manager';
    }
}
