<?php

namespace Jobtech\Support\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;
use Jobtech\Support\OpenSearch\Managers\Contracts\SearchManager as SearchManagerContract;

class SearchManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SearchManagerContract::class;
    }
}
