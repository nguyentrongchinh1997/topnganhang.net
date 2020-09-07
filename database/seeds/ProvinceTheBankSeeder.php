<?php

use Illuminate\Database\Seeder;
use App\Model\ProvinceTheBank;
use App\Model\DistrictTheBank;

class ProvinceTheBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = config('config.atm');

        foreach ($provinces as $provinceId => $provinceItem) {
            ProvinceTheBank::updateOrCreate(
                [
                    'id' => $provinceId
                ],
                [
                    'slug' => $provinceItem['slug'],
                    'name' => $provinceItem['name']
                ]
            );

            foreach ($provinceItem['quan_huyen'] as $districtId => $districtItem) {
                DistrictTheBank::updateOrCreate(
                    [
                        'id' => $districtId,
                        'slug' => $districtItem['slug'],
                    ],
                    [
                        'name' => $districtItem['name'],
                        'province_thebank_id' => $provinceId,
                    ]
                );
            }
        }
    }
}
