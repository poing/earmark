<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarmarkHoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earmark_hold', function (Blueprint $table) {
            $table->increments('id');
            $table->integer(config('earmark.columns.digit'));
            $table->string(config('earmark.columns.group'))->nullable();
            $table->timestamps();

            $table->index(config('earmark.columns.digit'));
            $table->index(config('earmark.columns.group'));
        });

        // Poing\Earmark\Models\EarMark::max('digit')
        // Poing\Earmark\Models\EarMark::where('type','alpha')->max('digit')
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('earmark_hold');
    }
}
