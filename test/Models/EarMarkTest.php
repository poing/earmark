<?php

namespace Earmark\Test\Models;

use Poing\Earmark\Models\EarMark;

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

    public function testRefill()
    {
        $earmark = new \Poing\Earmark\Http\Controllers\Serial('ZULU', 'A', 10, 2000, 5000);
        $data = $earmark->get();
        $earmark->get(30);
        $earmark->unset($data);
        $data = $earmark->get(30);
        $earmark->get(30);
        $earmark->unset($data);
        $earmark->increment();
        $this->assertEquals(30, count($earmark->get(30)));
    }
}
