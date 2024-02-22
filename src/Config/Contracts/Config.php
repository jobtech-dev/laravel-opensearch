<?php

namespace Jobtech\Support\Opensearch\Config\Contracts;

use Jobtech\Support\Opensearch\Contracts\Index;

interface Config
{
    public function indices(): array;

    public function resolveIndex(string $index): Index;

    public function resolvePrefix(): ?string;
}
