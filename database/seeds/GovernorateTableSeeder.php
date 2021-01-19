<?php

use Illuminate\Database\Seeder;

class GovernorateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(\App\Governorate::count()==0)
        {
            $governorate=\App\Governorate::create([
                'name'=>'alexandria',
            ]);
            $city=\App\City::create([
                'governorate_id'=>1,
                'name'=>'Alexandria',
            ]);
        }
    }
}
