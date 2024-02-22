<?php

namespace Jobtech\Support\Opensearch\Config;

use Illuminate\Contracts\Config\Repository;
use Jobtech\Support\Opensearch\Contracts\Index;
use Illuminate\Contracts\Foundation\Application;
use Jobtech\Support\Opensearch\Enums\OpensearchConfig;
use Jobtech\Support\Opensearch\Config\Contracts\Config as ConfigContract;

class Config implements ConfigContract
{
    public function __construct(
        private readonly Application $application,
        private readonly Repository $repository
    ) {}

    public function indices(): array
    {
        return $this->repository->get(OpensearchConfig::INDICES_KEY->value, []);
    }

    public function resolveIndex(string $index): Index
    {
        return $this->application->get(OpensearchConfig::INDICES_KEY->value.$index);
    }

    public function resolvePrefix(): ?string
    {
        return $this->repository->get(OpensearchConfig::PREFIX_KEY->value);
    }
}
