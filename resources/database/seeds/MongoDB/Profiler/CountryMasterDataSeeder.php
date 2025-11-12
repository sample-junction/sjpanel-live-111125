<<<<<<< HEAD
<?php

use Illuminate\Database\Seeder;

class CountryMasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonData = json_decode(file_get_contents(__DIR__ . '/master_country_data.json'), true);
        foreach($jsonData as $data){
            //dd($data['country_code']);
            \App\Models\MasterData\CountryMasterData::create([
                'country_code' => (!empty($data['country_code'])) ? $data['country_code'] : '',
                'country_name' => (!empty($data['country_name'])) ? $data['country_name'] : '',
                'country_data' => (!empty($data['country_data'])) ? $data['country_data'] : '',
                'fillable' => (!empty($data['fillable'])) ? $data['fillable'] : '',
                'field' => (!empty($data['field'])) ? $data['field'] : '',
            ]);
        }
    }
}
=======
<?php

use Illuminate\Database\Seeder;

class CountryMasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonData = json_decode(file_get_contents(__DIR__ . '/master_country_data.json'), true);
        foreach($jsonData as $data){
            //dd($data['country_code']);
            \App\Models\MasterData\CountryMasterData::create([
                'country_code' => (!empty($data['country_code'])) ? $data['country_code'] : '',
                'country_name' => (!empty($data['country_name'])) ? $data['country_name'] : '',
                'country_data' => (!empty($data['country_data'])) ? $data['country_data'] : '',
                'fillable' => (!empty($data['fillable'])) ? $data['fillable'] : '',
                'field' => (!empty($data['field'])) ? $data['field'] : '',
            ]);
        }
    }
}
>>>>>>> dev
