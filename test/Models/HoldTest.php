<?php

namespace Earmark\Test\Models;

use Poing\Earmark\Models\Hold;

#[CoversClass(Hole::class)]
class HoldTest extends AbstractTestCase
{
    #[CoversMethod('probe')]
    public function testHoldClass()
    {
        $this->assertTrue(Hold::probe());
    }

    public function test_commandTest()
    {
        $this->artisan('earmark:config')
            ->expectsOutput('EarMark installed successfully.')
            ->assertExitCode(0);
    }
}
