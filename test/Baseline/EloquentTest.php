<?php

namespace Earmark\Test\Baseline;

use Earmark\Test\Baseline\Models\BaseLineAlpha;

class EloquentTest extends UnitAbstract
{

    public function test_record_count_test()
    {
        factory(BaseLineAlpha::class, 50)->create();
        $this->assertEquals(BaseLineAlpha::count(), 50);
        echo '|';
    }
}
