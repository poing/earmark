<?php

namespace Poing\Earmark\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Poing\Earmark\Events\EarMarkRefill;
use Poing\Earmark\Http\Controllers\Serial;

class EarMarkLowHold implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EarMarkRefill  $event
     * @return void
     */
    public function handle(EarMarkRefill $event)
    {
        //Log::info('EarMarkLowHold.');

        $earmark = new Serial();
        $earmark->refill();
    }
}
