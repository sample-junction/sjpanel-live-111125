<<<<<<< HEAD
<?php

use Illuminate\Database\Seeder;

class CountryTransCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonData = json_decode(file_get_contents(__DIR__ . '/country_trans.json'), true);
        foreach ($jsonData as $country) {
            \App\Models\CountryTrans::create([
                'country_code' => (!empty($country['country_code'])) ? $country['country_code'] : '',
                'country_name' => (!empty($country['country_name'])) ? $country['country_name'] : '',
                'capital' => (!empty($country['capital'])) ? $country['capital'] : '',
                'currency_code' => (!empty($country['currency_code'])) ? $country['currency_code'] : '',
                'iso_3166_2' => (!empty($country['iso_3166_2'])) ? $country['iso_3166_2'] : '',
                'iso_3166_3' => (!empty($country['iso_3166_3'])) ? $country['iso_3166_3'] : '',
                'currency_symbol' => (!empty($country['currency_symbol'])) ? $country['currency_symbol'] : 0,
                'currency_decimals' => (!empty($country['currency_decimals'])) ? $country['currency_decimals'] : 0,
                'calling_code' => (!empty($country['calling_code'])) ? $country['calling_code'] : '',
                'flag' => (!empty($country['flag'])) ? $country['flag'] : '',
                'is_filterable' => (!empty($country['is_filterable'])) ? $country['is_filterable'] : 0,
                'translation' => (!empty($country['translation'])) ? $country['translation'] : '',
                'min_age' => (empty($country['min_age'])&& ($country['country_code']=="FR" || $country['country_code']=="DE")) ? 16 : 13,
            ]);
        }
    }
}
=======
<?php

use Illuminate\Database\Seeder;

class CountryTransCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonData = json_decode(file_get_contents(__DIR__ . '/country_trans.json'), true);
        foreach ($jsonData as $country) {
            \App\Models\CountryTrans::create([
                'country_code' => (!empty($country['country_code'])) ? $country['country_code'] : '',
                'country_name' => (!empty($country['country_name'])) ? $country['country_name'] : '',
                'capital' => (!empty($country['capital'])) ? $country['capital'] : '',
                'currency_code' => (!empty($country['currency_code'])) ? $country['currency_code'] : '',
                'iso_3166_2' => (!empty($country['iso_3166_2'])) ? $country['iso_3166_2'] : '',
                'iso_3166_3' => (!empty($country['iso_3166_3'])) ? $country['iso_3166_3'] : '',
                'currency_symbol' => (!empty($country['currency_symbol'])) ? $country['currency_symbol'] : 0,
                'currency_decimals' => (!empty($country['currency_decimals'])) ? $country['currency_decimals'] : 0,
                'calling_code' => (!empty($country['calling_code'])) ? $country['calling_code'] : '',
                'flag' => (!empty($country['flag'])) ? $country['flag'] : '',
                'is_filterable' => (!empty($country['is_filterable'])) ? $country['is_filterable'] : 0,
                'translation' => (!empty($country['translation'])) ? $country['translation'] : '',
                'min_age' => (empty($country['min_age'])&& ($country['country_code']=="FR" || $country['country_code']=="DE")) ? 16 : 13,
            ]);
        }
    }
}
>>>>>>> dev
