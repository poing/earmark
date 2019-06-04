<?php

namespace EarMark\Test\Models;

use EarMark\Test\Models\AbstractTest;
use Poing\EarMark\Models\Hold;

/**
 * @coversDefaultClass Poing\EarMark\Models\Hold
 */
class HoldTest extends AbstractTest
{

  /**
   * @covers Poing\EarMark\Models\Hold::probe()
   */
  public function testHoldClass()
  {
	$this->assertTrue(Hold::probe());
  }

}