<?php

namespace App\Listeners\Frontend\Auth;

use App\Models\Affiliate\AffiliateCampaignData;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendConversionHit
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Listener for handling the Event AffiliateConversion for redirecting the Promo User to Client Link after registration
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $aff_camp_data = $event->affiliateCampData;
        //dd($aff_camp_data);
        $aff_vars = json_decode($aff_camp_data->aff_vars, true);
        if(empty($aff_vars)){
            return;
        }
        $aff_vars = array_combine(
            array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),
            $aff_vars
        );
        $endUrl = $aff_camp_data->affiliate->c_link;
        $finalUrl = strtr($endUrl, $aff_vars);
        $this->backgroundVendorUrlHit($finalUrl);
        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);
    }

    public function backgroundVendorUrlHit($vendorurl){
        $cmd = "curl -X GET -H 'Content-Type: text/html'";
        $cmd.= " -d '' " . "'" . $vendorurl . "'";
        $cmd .= " > /dev/null 2>&1 &";
        exec($cmd, $output, $exit);
        $data = ['cmd' => $cmd, 'output' => $output, 'exit' => $exit];
        //file_put_contents( __DIR__.DIRECTORY_SEPARATOR.'S2S backgroundVendorUrlHit.txt', print_r($data, true), FILE_APPEND);
        return $exit == 0;
    }
    protected function sendIndirectHit($vendorurl){
        $curl = curl_init($vendorurl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        curl_close($curl);
    }
}
