<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Bouncer;
use Illuminate\Support\Facades\Hash;

class createAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {name} {email} {password}';

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

        $this->info('You are trying to add new user. By default, this user will be super admin. But, you can update role of this user later.');
        $email = $this->argument('email');
        $name  = $this->argument('name');
        $password = $this->argument('password');
        if (trim($email) == "" || trim($name) == "" || trim($password) == ""){
            $this->info('Missing field');
            return;
        }
        $user = User::where('email', $email)->first();
        if(!$user){
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            Bouncer::assign('admin')->to($user);
            $this->info('User '.$user->name.' has been generated !');
        } else {
            $this->info('User '.$user->name.' already existed !');
        }

    }
}
