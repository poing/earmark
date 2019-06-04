<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarmarkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earmark', function (Blueprint $table) {
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
        Schema::dropIfExists('earmark');
    }
}
