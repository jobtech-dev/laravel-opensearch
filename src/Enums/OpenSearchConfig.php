<?php

namespace Jobtech\Support\OpenSearch\Enums;

enum OpenSearchConfig: string
{
    case INDICES_KEY = 'opensearch.indices';

    case PREFIX_KEY = 'opensearch.prefix';
}
