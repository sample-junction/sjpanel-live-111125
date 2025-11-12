<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/9/2019
 * Time: 5:06 PM
 */
namespace App\Repositories\Inpanel\General;
use App\Models\Auth\User;
use App\Models\Country;
use App\Models\CountryTrans;
use function GuzzleHttp\Promise\queue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;




class GeneralRepository
{
    public function getActiveCountries()
    {
        return CountryTrans::where('is_filterable', 1)->get();
    }
}
