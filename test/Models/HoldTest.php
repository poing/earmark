<?php

namespace Earmark\Test\Models;

use Poing\Earmark\Models\Hold;

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

    /** @test */
    public function commandTest()
    {
        $this->artisan('earmark:config')
            ->expectsOutput('EarMark installed successfully.')
            ->assertExitCode(0);
    }
}
