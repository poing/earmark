<?php

namespace EarMark\Test\Models;

use EarMark\Test\Models\AbstractTest;
use Poing\EarMark\Models\Accrual;

/**
 * @coversDefaultClass Poing\EarMark\Models\Accrual
 */
class AccrualTest extends AbstractTest
{

  public function testData()
  {
    $test = new Accrual;
    $test->save();
    $this->assertTrue((Accrual::count() == 1));
  
  }

  /**
   * @covers Poing\EarMark\Models\Accrual::probe()
   */
  public function testAccrualClass()
  {
	$this->assertTrue(Accrual::probe());
  }

}