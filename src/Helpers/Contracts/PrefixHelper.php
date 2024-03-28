<?php

namespace Jobtech\Support\OpenSearch\Helpers\Contracts;

interface PrefixHelper
{
    public function parseIndex(string $index): string;
}
