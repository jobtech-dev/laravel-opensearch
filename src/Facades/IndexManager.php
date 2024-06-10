<?php

namespace Jobtech\Support\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool  existsIndex($index)
 * @method static array getIndex($index)
 * @method static array createIndex($index)
 * @method static array putIndexSettings($index)
 * @method static array putIndexMappings($index)
 * @method static array deleteIndex($index)
 * @method static array openIndex($index)
 * @method static array closeIndex($index)
 *
 * @see \Jobtech\Support\OpenSearch\Managers\Contracts\IndexManager
 */
class IndexManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'open-search-index-manager';
    }
}
