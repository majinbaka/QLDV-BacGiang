<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Bouncer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class initrolepermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:start';

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
        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $home = Bouncer::ability()->firstOrCreate(['name' => 'home', 'title' => 'View Home']);
        $group = Bouncer::ability()->firstOrCreate(['name' => 'group', 'title' => 'View Group']);
        $user = Bouncer::ability()->firstOrCreate(['name' => 'user', 'title' => 'View User']);

        Bouncer::allow($admin)->to($home);
        Bouncer::allow($admin)->to($group);
        Bouncer::allow($admin)->to($user);
    }
}
