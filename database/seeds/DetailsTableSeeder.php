<?php

use Illuminate\Database\Seeder;

class DetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = [
            [
                'id' => 1,
                'product_id' => 1,
                'ar' => [
                    'name' => 'تقطيع'
                ],
                'en' => [
                    'name' => 'slicing'
                ]
            ],
            [
                'product_id' => 1,
                'id' => 2,
                'ar' => [
                    'name' => 'طريقه تقطيع الرأس'
                ],
                'en' => [
                    'name' => 'head cutting'
                ]
            ],
            [
                'product_id' => 1,
                'id' => 3,
                'ar' => [
                    'name' => 'الحجم'
                ],
                'en' => [
                    'name' => 'size'
                ]
            ],
        ];
        foreach ($details as $detail) {
            \App\Detail::create($detail);
        }

    }//end of run

}//end of seeder
