<?php

namespace Jobtech\Support\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;

class DocumentManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'open-search-document-manager';
    }
}
