<?php

namespace Jobtech\Support\Opensearch\Enums;

enum OpensearchConfig: string
{
    case INDICES_KEY = 'opensearch.indices';

    case PREFIX_KEY = 'opensearch.prefix';
}
