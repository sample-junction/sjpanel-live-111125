<?php

use Illuminate\Database\Seeder;

class GeneralTablesSeeder extends Seeder
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

        $this->call(RedeemOptionTableSeeder::class);
        $this->call(StaticAchievementTableSeeder::class);

        $this->enableForeignKeys();
    }
}
