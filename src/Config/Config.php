<?php

namespace Jobtech\Support\OpenSearch\Config;

use Illuminate\Contracts\Config\Repository;
use Jobtech\Support\OpenSearch\Contracts\Index;
use Illuminate\Contracts\Foundation\Application;
use Jobtech\Support\OpenSearch\Enums\OpenSearchConfig;
use Jobtech\Support\OpenSearch\Config\Contracts\Config as ConfigContract;

class Config implements ConfigContract
{
    public function __construct(
        private readonly Application $application,
        private readonly Repository $repository
    ) {}

    public function indices(): array
    {
        return $this->repository->get(OpenSearchConfig::INDICES_KEY->value, []);
    }

    public function resolveIndex(string $index): Index
    {
        return $this->application->get(OpenSearchConfig::INDICES_KEY->value.$index);
    }

    public function resolvePrefix(): ?string
    {
        return $this->repository->get(OpenSearchConfig::PREFIX_KEY->value);
    }
}
