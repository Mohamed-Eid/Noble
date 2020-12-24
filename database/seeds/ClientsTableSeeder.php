<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            \App\Client::create([
               'api_token' => str_random(100),
               'district_id' => 1,
            ]);

    }//end of run

}//end of seeder
