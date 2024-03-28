<?php

namespace Jobtech\Support\OpenSearch\Config\Contracts;

use Jobtech\Support\OpenSearch\Contracts\Index;

interface Config
{
    public function indices(): array;

    public function resolveIndex(string $index): Index;

    public function resolvePrefix(): ?string;
}
