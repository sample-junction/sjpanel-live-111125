<<<<<<< HEAD
<?php

use Illuminate\Database\Seeder;

class AffiliateTableSeeder extends Seeder
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

        $this->call(AffiliateListSeeder::class);
        $this->call(AffiliateCampaignSeeder::class);

        $this->enableForeignKeys();
    }
}
=======
<?php

use Illuminate\Database\Seeder;

class AffiliateTableSeeder extends Seeder
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

        $this->call(AffiliateListSeeder::class);
        $this->call(AffiliateCampaignSeeder::class);

        $this->enableForeignKeys();
    }
}
>>>>>>> dev
