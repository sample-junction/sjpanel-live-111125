<?php

use Illuminate\Database\Seeder;

class AffiliateListSeeder extends Seeder
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

        \App\Models\Affiliate\AffiliateList::create([
            'name'          => 'samplejunction',
            'code'          => 'sj1001',
            'c_link'   => 'samppoint.com/end?status=1&sjid={aff_sub1}',
        ]);

        \App\Models\Affiliate\AffiliateList::create([
            'name'          => 'offerslook',
            'code'          => 'OLSJ1234',
            'c_link'   => 'http://sj.offerstrack.net/advBack.php?click_id={tid}&adv_id=1',
        ]);

        $this->enableForeignKeys();
    }
}
