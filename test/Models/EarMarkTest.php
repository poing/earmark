<?php

namespace Earmark\Test\Models;

use Poing\Earmark\Models\EarMark;

#[CoversClass(EarMark::class)]
class EarMarkTest extends AbstractTestCase
{
    #[CoversMethod('probe')]
    public function testEarMarkClass()
    {
        $this->assertTrue(EarMark::probe());
    }

    public function testRefill()
    {
        $earmark = new \Poing\Earmark\Http\Controllers\Serial;
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
