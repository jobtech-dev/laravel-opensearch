<?php

namespace Jobtech\Support\Opensearch\Events;

use Jobtech\Support\Opensearch\Contracts\Index;

/** @codeCoverageIgnore */
class IndexClosed
{
    public function __construct(public readonly Index $index) {}
}
