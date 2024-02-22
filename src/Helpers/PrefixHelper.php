<?php

namespace Jobtech\Support\Opensearch\Helpers;

use Jobtech\Support\Opensearch\Config\Contracts\Config;
use Jobtech\Support\Opensearch\Helpers\Contracts\PrefixHelper as PrefixHelperContract;

class PrefixHelper implements PrefixHelperContract
{
    public function __construct(private readonly Config $config) {}

    public function parseIndex(string $index): string
    {
        if (!($prefix = $this->config->resolvePrefix())) {
            return $index;
        }

        return sprintf('%s_%s', rtrim($prefix, '_'), $index);
    }
}
