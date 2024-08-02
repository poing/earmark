<?php

namespace Earmark\Test\Models;

use Poing\Earmark\Models\Accrual;

#[CoversClass(Accrual::class)]
class AccrualTest extends AbstractTestCase
{
    public function testData()
    {
        $test = new Accrual;
        $test->save();
        $this->assertTrue((Accrual::count() == 1));
    }

    #[CoversMethod('probe')]
    public function testAccrualClass()
    {
        $this->assertTrue(Accrual::probe());
    }
}
