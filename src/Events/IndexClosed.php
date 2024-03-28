<?php

namespace Jobtech\Support\OpenSearch\Events;

use Jobtech\Support\OpenSearch\Contracts\Index;

/** @codeCoverageIgnore */
class IndexClosed
{
    public function __construct(public readonly Index $index) {}
}
