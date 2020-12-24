<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cities = ['city one', 'city two', 'city three'];

        foreach ($cities as $city) {

            \App\City::create([
                'ar' => ['name' => $city],
                'en' => ['name' => $city],
            ]);

        }//end of foreach

    }//end of run

}//end of seeder
