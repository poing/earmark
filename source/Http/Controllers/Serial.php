<?php

namespace Poing\Earmark\Http\Controllers;

use DB;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Poing\Earmark\Events\EarMarkRefill;
use Poing\Earmark\Jobs\EarmarkQueue;

class Serial extends Controller
{
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
     * The default Eloquent models.
     */
    protected $model;

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
     * Create a new Serial instance.
     *
     * @param  string  $altPrefix
     * @param  string  $altMin
     * @param  int  $guards
     * @return void
     */
    public function __construct($altPrefix = null, $altSuffix = null, $altPadding = null, $altMin = null, $altMax = null)
    {
        //Log::debug('Serial Construct');

        $this->model = config('earmark.model');

        $this->prefix = $altPrefix ?: config('earmark.prefix');
        $this->suffix = $altSuffix ?: config('earmark.suffix');

        $this->digit = config('earmark.columns.digit');
        $this->group = config('earmark.columns.group');
        $this->min = ! is_null($altMin) ? $altMin : config('earmark.range.min');
        $this->max = ! is_null($altMax) ? $altMax : config('earmark.range.max');
        $this->padding = ! is_null($altPadding) ? $altPadding : config('earmark.padding');

        $this->initHold();
    }

    public function get($count = null)
    {
        if ($count) {
            $data = [];
            $i = 1;

            for ($i; $i <= $count; $i++) {
                $data[] = $this->affix($this->getEarMark());
            }
            //event(new EarMarkRefill());
            EarmarkQueue::dispatch($this->prefix, $this->suffix, $this->padding, $this->min, $this->max);

            return $data;
        } else {
            // event(new EarMarkRefill());
            EarmarkQueue::dispatch($this->prefix, $this->suffix, $this->padding, $this->min, $this->max);

            return $this->affix($this->getEarMark());
        }
    }

    public function unset($value)
    {
        $model = config('earmark.model');

        if (is_array($value)) {
            foreach ($value as $data) {
                $model::where($this->group, $this->prefix)->
                //where($this->suffix_col,$this->suffix)->
                where($this->digit, $this->unfix($data))->
                delete();
            }
        } else {
            if (! empty($value)) {
                //$data $this->unfix($data);

                return $model::where($this->group, $this->prefix)->
                //where($this->suffix_col,$this->suffix)->
                where($this->digit, $this->unfix($value))->
                delete();
            }
        }
    }

    private function affix($number)
    {
        $data = $this->zeroPadding($number);

        return $this->prefix.$data; // . $this->suffix;
    }

    private function unfix($number)
    {
        $data = ltrim($number, $this->prefix);
        //return rtrim($data,$this->suffix);
        return $data;
    }

    public function getMax()
    {
        $model = config('earmark.model');

        return max([
            $model::where($this->group, $this->prefix)->max($this->digit),
            $this->min,
        ]);
    }

    private function zeroPadding($value)
    {
        return str_pad($value, $this->padding, '0', STR_PAD_LEFT);
    }

    public function increment($fill = false)
    {
        $model = config('earmark.accrual');
        $inc = new $model;
        $inc->save();

        return $fill ? $this->zeroPadding($inc->id) : $inc->id;
    }

    private function generateHold()
    {
        $model = config('earmark.model');
        $hold = config('earmark.hold_model');

        $max = $this->getMax() + config('earmark.hold');

        $n = 1;

        for ($i = $this->min; $i <= $max; $i++) {
            $used = $model::where(
                        $this->group,
                        $this->prefix
                    )->where(
                        $this->digit,
                        $i
                    )->count();

            $unused = $hold::where(
                        $this->group,
                        $this->prefix
                    )->where(
                        $this->digit,
                        $i
                    )->count();

            if ((! $used) && (! $unused)) {
                if ($n <= config('earmark.hold')) {
                    $this->insertHold($i);
                    $n++;
                } else {
                    break;
                }
            }
        }
    }

    public function refill()
    {
        Log::info('Check Refill');

        $hold = config('earmark.hold_model');
        $count = $this->checkHold();
        $floor = config('earmark.hold') / 3;
        if ($count < $floor) {
            Log::info('Earmark Refilled for '.$this->prefix);

            $this->generateHold();
        }
    }

    private function checkHold()
    {
        $hold = config('earmark.hold_model');

        return $hold::where($this->group, $this->prefix)->count();
    }

    private function initHold()
    {
        //Log::debug('Earmark Hold Intilized');
        if ($this->checkHold() == 0) {
            $this->generateHold();
            Log::info('Earmark Hold Intilized for '.$this->prefix);
        }
    }

    private function getEarMark()
    {
        // $this->initHold();

        $hold = config('earmark.hold_model');
        $model = config('earmark.model');

        $digit = $this->digit;
        $group = $this->group;

        $data = null;

        //$this->initHold();

        DB::transaction(
            function () use (&$hold, &$model, &$digit, &$group, &$data
        ) {
                $pull = $hold::where(
                $this->group,
                $this->prefix
            )->first();
                $data = $pull->digit;
                $hold::destroy($pull->id);

                $push = new $model;
                $push->digit = $data;
                $push->$group = $this->prefix;
                $push->save();
            });

        //if ($this->checkHold() < config('earmark.hold'))
        //event(new EarMarkRefill());
        // $this->prefix, $this->suffix, $this->padding, $this->min, $this->max
        //EarmarkQueue::dispatch($this->prefix, $this->suffix, $this->padding, $this->min, $this->max);

        return $data;
    }

    private function insertHold($newDigit)
    {
        $model = config('earmark.hold_model');

        $digit = $this->digit;
        $group = $this->group;

        $data = new $model;
        $data->digit = $newDigit;
        $data->$group = $this->prefix;
        $data->save();
    }

    // Poing\Earmark\Models\EarMark::max('digit')
        // Poing\Earmark\Models\EarMark::where('type','alpha')->max('digit')
}
