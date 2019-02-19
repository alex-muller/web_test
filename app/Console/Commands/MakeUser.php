<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MakeUser {email} {passport}';

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
        $email = $this->argument('email');
        $password = $this->argument('passport');
        
        $user = new User();
        $user->email = $email;
        $user->name = substr($email,0, strpos($email,'@'));
        $user->setPassword($password);
        $user->save();
        
    }
}
