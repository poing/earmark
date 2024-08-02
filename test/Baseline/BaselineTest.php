<?php

namespace Earmark\Test\Baseline;

use PHPUnit\Framework\TestCase;

class BaselineTest extends TestCase
{
    use MyTrait;

    public function test_true_is_true()
    {
        $this->assertTrue(true);
    }

    public function test_trait_test()
    {
        $this->assertTrue($this->stub());
    }
}
