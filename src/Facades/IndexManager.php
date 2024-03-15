<?php

namespace Jobtech\Support\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;
use Jobtech\Support\OpenSearch\Managers\Contracts\IndexManager as IndexManagerContract;

class IndexManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return IndexManagerContract::class;
    }
}
