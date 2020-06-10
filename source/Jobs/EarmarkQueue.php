<?php

namespace Poing\Earmark\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Poing\Earmark\Http\Controllers\Serial;

class EarmarkQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The prefix and suffix variables.
     */
    protected $prefix;
    protected $suffix;

    /**
     * The table column name variables.
     */
    protected $digit;
    protected $group;

    /**
     * The range variables.
     */
    protected $min;
    protected $max;

    /**
     * The Zero Padding Value.
     */
    protected $padding;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($prefix, $suffix, $padding, $min, $max)
    {
        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->padding = $padding;
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $earmark = new Serial($this->prefix, $this->suffix, $this->padding, $this->min, $this->max);
        $earmark->refill();
    }
}
