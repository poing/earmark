<?php

use Illuminate\Database\Seeder;

class BaseLineAlpha extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BaseLineAlpha::class, 50)->create();
    }
}
