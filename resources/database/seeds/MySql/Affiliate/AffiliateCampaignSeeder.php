<?php

use Illuminate\Database\Seeder;
use App\Models\Affiliate\AffiliateCampaign;

class AffiliateCampaignSeeder extends Seeder
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
        /*AffiliateCampaign::create([
            'name'          => 'single_optin_promotion_campaign',
            'code'          => 'single_optin_promotion_campaign',
            'c_type'   => 'soi',
            'payout'   => 2,
        ]);

       AffiliateCampaign::create([
            'name'          => 'doi_campaign',
            'code'          => 'doi_campaign',
            'c_type'   => 'doi',
            'payout'   => 3,
        ]);*/
        /*AffiliateCampaign::create([
            'name'          => 'doi_plus_survey_taken_camp',
            'code'          => 'doi_plus_survey_taken_camp',
            'c_type'   => 'profile_filled',
            'payout'   => 4,
        ]);
        AffiliateCampaign::create([
            'name'          => 'survey_taken_camp',
            'code'          => 'survey_taken_camp',
            'c_type'   => 'first_survey',
            'payout'   => 6,
        ]);*/
        AffiliateCampaign::create([
            'name'          => 'profile_complete',
            'code'          => 'profile_cmp',
            'c_type'   => 'profile_cmp',
            'payout'   => 6,
        ]);
        AffiliateCampaign::create([
            'name'          => 'profile_complete_survey_attempt',
            'code'          => 'pfc_sat',
            'c_type'   => 'pfc_sat',
            'payout'   => 6,
        ]);
        AffiliateCampaign::create([
            'name'          => 'profile_complete_survey_complete',
            'code'          => 'pfc_sc',
            'c_type'   => 'pfc_sc',
            'payout'   => 6,
        ]);
        $this->enableForeignKeys();
    }
}
