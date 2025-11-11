<?php

use Illuminate\Database\Seeder;

class BatchProfilerSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->call(CountryTransCollectionSeeder::class);
        $this->call(CountryMasterDataSeeder::class);

        $this->enableForeignKeys();
    }
}
