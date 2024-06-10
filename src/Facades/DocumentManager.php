<?php

namespace Jobtech\Support\OpenSearch\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method array retrieveDocument(string $index, string $id)
 * @method array createDocument(string $index, string $id, array $body, bool $refresh = true)
 * @method array createDocumentWithoutId(string $index, array $body, bool $refresh = true)
 * @method array createDocumentFrom(array $params)
 * @method array updateDocument(string $index, string $id, array $body, bool $refresh = true)
 * @method array upsertDocument(string $index, string $id, array $body, bool $refresh = true)
 * @method array deleteDocument(string $index, string $id)
 * @method array countDocument(string $index, ?array $body = [])
 *
 * @see \Jobtech\Support\OpenSearch\Managers\Contracts\DocumentManager
 */
class DocumentManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'open-search-document-manager';
    }
}
