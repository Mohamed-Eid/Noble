<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'ar' => [
                    'name' => 'نعيمي'
                ],
                'en' => [
                    'name' => 'Naaimi'
                ]
            ],
            [
                'ar' => [
                    'name' => 'مجدي'
                ],
                'en' => [
                    'name' => 'Nagdi'
                ]
            ],
        ];

        foreach ($products as $product) {

            \App\Product::create($product);

        }//end of foreach

    }//end of run

}//end of seeder
