<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class LaragonTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:laragon-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        info('hello from laragon testing cron', []);
        $u = User::first();
        $u->name = date('H:i:s.u');
        $u->save();
    }
}
