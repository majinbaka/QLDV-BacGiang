<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Bouncer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class createAdmin extends Command
{
    protected $signature = 'admin:create {name} {username} {email} {password}';
    protected $description = 'admin:create {name} {username} {email} {password}';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $this->info('You are trying to add new user. By default, this user will be super admin. But, you can update role of this user later.');
        $email = $this->argument('email');
        $name  = $this->argument('name');
        $username  = $this->argument('username');
        $password = $this->argument('password');

        if (trim($email) == "" || trim($name) == "" || trim($password) == "") {
            $this->info('Missing field');

            return;
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $name;
            $user->username = $username;
            $user->email = $email;
            $user->uuid = Str::uuid();
            $user->password = Hash::make($password);
            $user->save();
            Bouncer::assign('admin')->to($user);

            $this->info('User '.$user->name.' has been generated !');
        } else {
            $this->info('User '.$user->name.' already existed !');
        }
    }
}
