<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=\App\User::create([
           'name'=>'admin',
           'email'=>'admin@admin.com',
           'password'=>bcrypt('123456789'),
            'type'=>'admin',
            'photo'=>'profile.PNG'
        ]);
    }
}
