<?php

namespace App\Console\Commands;

use App\Infrastructure\Interfaces\IRemoteStorageClient;
use Illuminate\Console\Command;

class PutFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PutFile {localKey}';

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
        $localKey = $this->argument('localKey');
        $rsClient = app()->make(IRemoteStorageClient::class);

        var_dump($rsClient->getItemsList());
        $rsClient->putItem($localKey);
        var_dump($rsClient->getItemsList());


        echo 'DONE';
    }
}
