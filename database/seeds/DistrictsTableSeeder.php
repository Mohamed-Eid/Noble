<?php

use Illuminate\Database\Seeder;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $districts = ['district one', 'district two', 'district three'];

        foreach ($districts as $district) {

            \App\District::create([
                'city_id'     => 1,
                'ar' => ['name' => $district],
                'en' => ['name' => $district],
            ]);

        }//end of foreach

    }//end of run

}//end of seeder
