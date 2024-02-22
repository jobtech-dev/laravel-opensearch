<?php

namespace Jobtech\Support\Opensearch\Helpers\Contracts;

interface PrefixHelper
{
    public function parseIndex(string $index): string;
}
