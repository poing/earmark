<?php

namespace Poing\Earmark\Models;

use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'earmark_hold';

    /**
     * Used to test phpunit access to this class
     */
    public static function probe()
    {
        return true;
    }
    
}
