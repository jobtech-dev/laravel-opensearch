<?php

namespace Jobtech\Support\OpenSearch\Events;

use Jobtech\Support\OpenSearch\Contracts\Index;

/** @codeCoverageIgnore */
class IndexOpened
{
    public function __construct(public readonly Index $index) {}
}
