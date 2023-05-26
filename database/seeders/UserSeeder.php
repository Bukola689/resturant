<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // \App\Models\User::factory()->create();

       User::factory()->count(2)
       ->create()
       ->each(
           function($user) {
               $user->assignRole('admin');
           }
       );

        User::factory()->count(3)
        ->create()
        ->each(
            function($user) {
                $user->assignRole('manager');
            }
        );

        User::factory()->count(3)
        ->create()
        ->each(
            function($user) {
                $user->assignRole('chef');
            }
        );

        User::factory()->count(4)
        ->create()
        ->each(
            function($user) {
                $user->assignRole('customer');
            }
        );

        User::factory()->count(2)
        ->create()
        ->each(
            function($user) {
                $user->assignRole('user');
            }
        );
    }
}
