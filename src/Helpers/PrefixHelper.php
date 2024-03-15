<?php

namespace Jobtech\Support\OpenSearch\Helpers;

use Jobtech\Support\OpenSearch\Config\Contracts\Config;
use Jobtech\Support\OpenSearch\Helpers\Contracts\PrefixHelper as PrefixHelperContract;

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
