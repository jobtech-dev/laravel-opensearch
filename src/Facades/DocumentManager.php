<?php

namespace Jobtech\Support\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;
use Jobtech\Support\OpenSearch\Managers\Contracts\DocumentManager as DocumentManagerContract;

class DocumentManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'open-search-document-manager';
    }
}
