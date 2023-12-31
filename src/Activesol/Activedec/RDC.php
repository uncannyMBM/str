<?php

namespace StrIlluminate\StrIlluminate\Activesol\Activedec;

use Facades\StrIlluminate\StrIlluminate\Activewor\BS;
use Illuminate\Console\Command;

class RDC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:installer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        @unlink(BS::getTheHeck());
        $this->info('Installer reset successfully.');
    }
}
