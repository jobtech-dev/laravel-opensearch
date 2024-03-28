<?php

namespace Jobtech\Support\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;

class IndexManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'open-search-index-manager';
    }
}
