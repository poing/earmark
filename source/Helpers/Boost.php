<?php

namespace Poing\Earmark\Helpers;

/**
 * Junk code, attempt to use function in factory.
 * @codeCoverageIgnore
 */
class Boost
{
    public function autoIncrement()
    {
        for ($i = config('earmark.range.min') - 1; $i < config('earmark.range.max'); $i++) {
            yield $i;
        }
    }
}
