<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'cache',
            'jobs',
            'sessions',
        ]);

        $this->call(AuthTableSeeder::class);
        $this->call(BatchProfilerSeeder::class);
        $this->call(GeneralTablesSeeder::class);
        $this->call(ProjectBatchSeeder::class);
        $this->call(AffiliateTableSeeder::class);

        //Profiler Seeder Collections
        //$this->call(BatchProfilerSeeder::class);

        Model::reguard();
    }
}
