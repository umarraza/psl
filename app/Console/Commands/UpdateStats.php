<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AppCommand;

class UpdateStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateStats';

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
         AppCommand::matchesChecker();
         AppCommand::statsChecker();
        // \Storage::disk('local')->put('fiaaaasasle.txt', 'Conteasasasqqqqqnasasts');
        //echo "chal gai";
    }
}
