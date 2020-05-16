<?php

namespace Poing\Earmark\Commands;

use Illuminate\Console\Command;

class EarMarkInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'earmark:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install EarMark Configuration File';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Publishing EarMark Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'earmark-config']);
        $this->info('EarMark installed successfully.');
    }
}
