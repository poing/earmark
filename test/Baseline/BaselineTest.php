<?php

namespace Earmark\Test\Baseline;

use PHPUnit\Framework\TestCase;

class BaselineTest extends TestCase
{
    use MyTrait;

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function trait_test()
    {
        $this->assertTrue($this->stub());
    }
}
