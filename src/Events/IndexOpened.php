<?php

namespace Jobtech\Support\Opensearch\Events;

use Jobtech\Support\Opensearch\Contracts\Index;

/** @codeCoverageIgnore */
class IndexOpened
{
    public function __construct(public readonly Index $index) {}
}
