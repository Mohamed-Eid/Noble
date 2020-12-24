<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Role;
use App\User;

class CreateSuperUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create_super_admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Super Admin Account';



    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [
            'first_name' => '90',
            'last_name' => 'days',
            'email' => 'test@test.com',
            'password' => bcrypt('123456'),
            ];
        
        $user = User::create($data);

        $user->attachRole('super_admin');

        $role = Role::find(1);

        $user->syncPermissions($role->permissions);
        
        $this->info('account created , u can login now');
    }
}
