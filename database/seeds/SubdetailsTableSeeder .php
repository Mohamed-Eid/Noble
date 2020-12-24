<?php

use Illuminate\Database\Seeder;

class SubdetailsTableSeeder extends Seeder
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
                'detail_id' => 1,
                'ar' => [
                    'name' => 'تقطيع'
                ],
                'en' => [
                    'name' => 'slicing'
                ],
                'price' => 200,
            ],
            [
                'detail_id' => 1,
                'ar' => [
                    'name' => 'سلخ'
                ],
                'en' => [
                    'name' => 'Skinning'
                ],
                'price' => 300,

            ],
            [
                'detail_id' => 1,
                'ar' => [
                    'name' => 'الحجم'
                ],
                'en' => [
                    'name' => 'size'
                ],
                'price' => 900,

            ],
        ];
        foreach ($details as $detail) {
            \App\Subdetail::create($detail);
        }

    }//end of run

}//end of seeder
