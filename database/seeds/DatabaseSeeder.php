<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(LaratrustSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(DistrictsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(DetailsTableSeeder::class);
    }
}
