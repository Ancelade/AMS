<?php

namespace App\Console\Commands;

use App\Models\Config;
use Illuminate\Console\Command;
use InfluxDB\Client;

class DropDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:drop-database';

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
        $client = new Client(
            env('INFLUX_HOST'),
            8086,
            env('INFLUX_USERNAME')
        );


        $database = $client->selectDB(env('INFLUX_DB'));
        $database->drop();
    }
}
