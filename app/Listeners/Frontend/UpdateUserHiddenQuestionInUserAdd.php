<?php

namespace App\Listeners\Frontend;

use App\Events\Frontend\Auth\UserUpdated;
use App\Models\CountryTrans;
use App\Models\MasterData\CountryMasterData;
use App\Models\Profiler\UserAdditionalData;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserHiddenQuestionInUserAdd
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Listener for handle the Event User Update for updating the Hidden Autopunch in User Additional.
     *
     * @param $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        $user = $event->user;
        $get_user_add_data = UserAdditionalData::where('uuid','=',$user->getUuid())->first();
        $userAnswers = collect($get_user_add_data->user_answers);
        $basicProfile = $userAnswers
            ->where('profile_section_code', '=', 'HIDDEN');
        if($basicProfile->isEmpty()){
            $country= $user->country_code;
            $country = CountryTrans::where('country_code','=',$country)->first();
            if($country->country_code == 'US'){
                $this->fillAdditionalDataForUS($user);
            }else if ($country->country_code == 'CA') {
                $this->fillAdditionalDataForCA($user);
            }else if ($country->country_code == 'UK') {
                $this->fillAdditionalDataForUK($user);
            }else if ($country->country_code == 'FR') {
                $this->fillAdditionalDataForFR($user);
            }
        }
    }

    /**
     * This action is used for filling additional hidden autopunch data for the User who is from US.
     *
     * @param $user
     * @return bool
     */
    private function fillAdditionalDataForUS($user)
    {
        $country_master = CountryMasterData::where('country_code','=',$user->country_code)->first();
        $fillable = $country_master->fillable;
        $zipcode = $user->zipcode;
          $projectionArray = [
              '_id' => true,
              'country_code' => true,
              'country_name' => true,
          ];
      /*  $projectionArray = self::$answersProjectionArray;*/
        $projectionArray['country_data']['$elemMatch']['zip'] = "$zipcode";
        $zip_data = CountryMasterData::where('country_code','=',$user->country_code)
            ->project($projectionArray)
            ->first();

        if (empty($zipcode) || empty($zip_data)) {
            return false;
        }
        $insertData = [];
        if($zip_data->country_data ){
            foreach ($fillable as $key => $column_name) {
                foreach ($zip_data->country_data as $data){
                    $insertData[] = [
                        'profile_section_code' => 'HIDDEN',
                        'profile_question_code' => $key,
                        'selected_answer' => [(!empty($data[$column_name]))?$data[$column_name]:null,]
                    ];
                }
            }
            UserAdditionalData::where('uuid','=',$user->uuid)->push('user_answers', $insertData);
            return true;
        }
        return false;
     }

    /**
     * This action is used for filling additional hidden autopunch information of the User from Canada.
     *
     * @param $user
     * @return bool
     */
     private function fillAdditionalDataForCA($user)
     {
         $country_master = CountryMasterData::where('country_code','=',$user->country_code)->first();
         $fillable = $country_master->fillable;
         $zipcode = $user->zipcode;
         $projectionArray = [
             '_id' => true,
             'country_code' => true,
             'country_name' => true,
         ];
         /*  $projectionArray = self::$answersProjectionArray;*/
         $projectionArray['country_data']['$elemMatch']['postcode'] = "$zipcode";
         $zip_data = CountryMasterData::where('country_code','=',$user->country_code)
             ->project($projectionArray)
             ->first();
         $insertData = [];
         if($zip_data->country_data){
             foreach ($fillable as $key => $column_name) {
                 foreach ($zip_data->country_data as $data){
                     $insertData[] = [
                         'profile_section_code' => 'HIDDEN',
                         'profile_question_code' => $key,
                         'selected_answer' => [(!empty($data[$column_name]))?$data[$column_name]:null],
                     ];
                 }
             }
             UserAdditionalData::where('uuid','=',$user->uuid)->push('user_answers', $insertData);
             return true;
         }
         return false;
     }

    /**
     * This action is used for filling additional hidden autopunch information of the User from France.
     *
     * @param $user
     * @return bool
     */

     private function fillAdditionalDataForFR($user)
     {
         $country_master = CountryMasterData::where('country_code','=',$user->country_code)->first();
         $fillable = $country_master->fillable;
         $zipcode = $user->zipcode;
         $insertData = [];
         $action = 'communes';
         $parameters = '';

         $queryArray = [
             'codePostal' => $zipcode,
             'fields' => 'nom,code,departement,region',
             'format' => 'json',
             'geometry' => 'centre',
         ];
         $response = $this->executeAPIForFrancePostcode($action, $parameters, $queryArray);
         if( $response->getStatusCode() == 200 ){
             $postcodeDetail = json_decode($response->getBody()->getContents());
             if ( !empty($postcodeDetail) ) {
                 $result = $postcodeDetail[0];
                 $department = $result->departement->nom;
                 $projectionArray = [
                     '_id' => true,
                     'country_code' => true,
                     'country_name' => true,
                 ];
                 /*  $projectionArray = self::$answersProjectionArray;*/
                 $projectionArray['country_data']['$elemMatch']['department'] = "$department";
                 $masterData = CountryMasterData::where('country_code','=',$user->country_code)
                     ->project($projectionArray)
                     ->first();
                 $insertData = [];
                 foreach ($fillable as $key => $column_name) {
                     foreach ($masterData->country_data as $data){
                         $insertData[] = [
                             'profile_section_code' => 'HIDDEN',
                             'profile_question_code' => $key,
                             'selected_answer' => [(!empty($data[$column_name]))?$data[$column_name]:null,]
                         ];
                     }
                 }
                 UserAdditionalData::where('uuid','=',$user->uuid)->push('user_answers', $insertData);
             }
             // json_last_error();
         }else{
             //dd('In Else',$response);
             return false;
         }
         return false;
     }

    /**
     * This action is used for hitting the Api fo getting all the hidden details of the User
     * who is from France.
     *
     * @param $user
     * @return array
     */
    private function executeAPIForFrancePostcode($action, $parameters, $queryArray = [])
    {

        $client = new Client(['base_uri' => 'https://geo.api.gouv.fr/']);
        try {
            $response = $client->request('GET', "$action" . "/" . "$parameters", [
                'query' => $queryArray,
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'X-Foo' => ['Bar', 'Baz']
                ],
            ]);
        } catch (ServerException $e) {
            $response = $e->getResponse();
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }
        return $response;
    }

    /**
     * This action is used for filling additional hidden autopunch information of the User from United Kingdom.
     *
     * @param $user
     * @return bool
     */
    private function fillAdditionalDataForUK($user)
    {
        $country_master = CountryMasterData::where('country_code', '=', $user->country_code)->first();
        $fillable = $country_master->fillable;
        $zipcode = $user->zipcode;
        $insertData = [];
        $action = 'communes';
        $parameters = '';
        $action = 'postcodes';
        $parameters = $zipcode;
        $response = $this->executeAPIForPostcodesIO($action, $parameters);
        if( $response->getStatusCode() == 200 ){
            $postcodeDetail = json_decode($response->getBody()->getContents());
            if ($postcodeDetail->status == '200') {
                $result = $postcodeDetail->result;
                $insertData = [];
                foreach ($fillable as $keyname => $attr) {

					
					if (property_exists($result, $attr)) {

						$insertData[] = [
							'profile_section_code' => 'HIDDEN',
							'profile_question_code' => $keyname,
							'selected_answer' => [$result->$attr],
						];
					}
                }
                /*[
                    'county' => $result->nuts,
                    'region' => $result->european_electoral_region,
                ]*/
                $projectionArray = [
                    '_id' => true,
                    'country_code' => true,
                    'country_name' => true,
                ];
                /*  $projectionArray = self::$answersProjectionArray;*/
               /* $projectionArray['country_data']['$elemMatch']['region']['county'] = "$result->european_electoral_region","$result->nuts";*/
                 $projectionArray['country_data'] = [
                     '$elemMatch' => [
                         'region' => "$result->european_electoral_region",
                         //'county' => "$result->nuts",
                         'county' => ($result->nuts) ? "$result->nuts" : "",
                     ]
                 ];
                $masterData = CountryMasterData::where('country_code','=',$user->country_code)
                    ->project($projectionArray)
                    ->first();
               if(!$masterData->country_data){
                   $zipdata = CountryMasterData::where('country_code','=',$user->country_code)
                       ->push('country_data',[
                           //'county' => $result->nuts,
                           'county' => ($result->nuts) ? $result->nuts : "",
                           'region' => $result->european_electoral_region,
                       ]);
               }
                UserAdditionalData::where('uuid','=',$user->uuid)->push('user_answers', $insertData);
            }

            // json_last_error();
        }else{
            //dd('In Else',$response);
            return false;
        }
        return false;
    }

    private function executeAPIForPostcodesIO($action, $parameters)
    {

        $client = new Client(['base_uri' => 'https://api.postcodes.io/']);
        try {
            $response = $client->request('GET', "$action" . "/" . "$parameters", [
                'query' => [],
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'X-Foo' => ['Bar', 'Baz']
                ],
            ]);
        } catch (ServerException $e) {
            $response = $e->getResponse();
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }
        return $response;
    }
}
