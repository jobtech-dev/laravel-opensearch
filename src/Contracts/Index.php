<?php

namespace Jobtech\Support\OpenSearch\Contracts;

interface Index
{
    public function name(): string;

    public function mappings(): array;

    public function settings(): array;

    public function aliases(): array;
}
