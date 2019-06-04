<?php

namespace EarMark\Test\Models;

use EarMark\Test\Models\AbstractTest;
use Poing\EarMark\Models\EarMark;

/**
 * @coversDefaultClass Poing\EarMark\Models\EarMark
 */
class EarMarkTest extends AbstractTest
{

  /**
   * @covers Poing\EarMark\Models\EarMark::probe()
   */
  public function testEarMarkClass()
  {
	$this->assertTrue(EarMark::probe());
  }

}