<?php

namespace App\Listeners\Frontend;

use App\Events\Frontend\Auth\UserUpdated;
use App\Models\Auth\User;
use App\Models\Profiler\ProfileSection;
use App\Models\Profiler\UserAdditionalData;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBasicDetailInUserAdd
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
     * Listener for handling the Event of User Update for updating the user basic details in User Additional Collection.
     *
     * @param $event
     * @return boolean
     */
    public function handle(UserUpdated $event)
    {
        $code = [];
        $answersArray = [];
        $user = $event->user;
        $gender = $user->gender;

        $basic_profile_general_name = 'BASIC';

        if($gender=='Male' || $gender=='Masculino' || $gender=='mâle' || $gender=='homme' || $gender=='Mâle' || $gender=='Homme'){
            $gender = 1;
        } else if($gender == 'Female' || $gender=='Hembra' || $gender=='femelle' || $gender=='femme' || $gender=='Femelle' || $gender=='Femme') {
            $gender = 2;
        }
        $zip_code = $user->zipcode;
        $dob = $user->dob;
         $country=$user->country_code;
        $age = date_diff( date_create($dob), date_create('today') )->y;
        $get_user_add_data = UserAdditionalData::where('uuid','=',$user->getUuid())->first();
        //$get_profile_section = ProfileSection::where('general_name','=','BASIC')->first();
        $get_gender_question_code = $this->getGenderQuestionCode();
        $get_age_question_code = $this->getAgeQuestionCode();
        $get_zip_question_code = $this->getZipQuestionCode();
        $code['age'] = $get_age_question_code;
        $code['gender'] = $get_gender_question_code;
        $code['zip'] = $get_zip_question_code;
        if($country=='IN'){
            $basic_profile_general_name = 'MY_PROFILE';
            [$state, $city, $region, $stateAbbreviation]=$this->getCity($country,$user->zipcode);
            $cityName = $city ?? null;
            $preCode=$this->CheckIndiaCity($cityName);
            $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => 'STANDARD_INDIAN_CITIES',
                    'selected_answer' => [$preCode]
                ];
                
            $stateName = $state ?? null;
            $preCode=$this->CheckIndiaState($stateName);
            $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => 'STANDARD_INDIAN_STATE',
                    'selected_answer' => [$preCode]
                ];
        }
        foreach ($code  as $key => $value){
            if( $key == 'age'){
                $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => $get_age_question_code,
                    'selected_answer' => [$age]
                ];
            } elseif( $key == 'gender' ) {
                $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => $get_gender_question_code,
                    'selected_answer' => [$gender]
                ];
            } elseif( $key == 'zip' ) {
                $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => $get_zip_question_code,
                    'selected_answer' => [$zip_code]
                ];
            }
        }

        if( $get_user_add_data->user_answers ){
            $new_data = [];

            $userAnswers = collect($get_user_add_data->user_answers);
            $basicProfile = $userAnswers
                ->where('profile_section_code', '=', 'BASIC');
            $newUserAnswers = $userAnswers
                ->where('profile_section_code', '!=', 'BASIC')
                ->toArray();

            if ( $basicProfile->isEmpty() ) {
                $new_data = $answersArray;
            }else{
                foreach ( $basicProfile as $basic_user_answers) {
                    foreach ($answersArray as $answer) {
                        if( $answer['profile_question_code'] == $basic_user_answers['profile_question_code'] ){
                            $new_data[] = [
                                'profile_section_code' => $basic_user_answers['profile_section_code'],
                                'profile_question_code' => $basic_user_answers['profile_question_code'],
                                'selected_answer' => $answer['selected_answer'],
                            ];
                        }
                    }
                }
            }
            if(!empty($new_data)){
                $newUserAnswers = array_merge( $newUserAnswers, $new_data );
            }
            $user_Add_data = UserAdditionalData::where('uuid','=',$user->uuid)
                ->first();
            $user_Add_data->user_answers = $newUserAnswers;
            $user_Add_data->save();
            return true;
        }

        if ( empty($get_user_add_data) ) {
            $newdata = [
                'uuid' => $user->uuid,
                'u_id' => $user->id,
                'user_answers' => $answersArray,
            ];
            UserAdditionalData::create($newdata);
            return true;
        }

        if( empty($get_user_add_data->user_answers) ){
            $get_user_add_data->push( 'user_answers', $answersArray);
            $get_user_add_data->save();
            return true;
        }
    }

    private function getGenderQuestionCode()
    {
        $code = 'GLOBAL_GENDER';
        return $code;
    }

    private function getAgeQuestionCode()
    {
        $code = 'GLOBAL_AGE';
        return $code;
    }

    private function getZipQuestionCode()
    {
        $code = 'GLOBAL_ZIP';
        return $code;
    }

private function getCity($country_code,$zipcode){
        $url = "https://api.zippopotam.us/{$country_code}/{$zipcode}";
        //dd($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            // cURL request failed
            // echo "Error: " . curl_error($ch);
            return null;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            // HTTP request failed
            // echo "HTTP Error: " . $http_code;
            return null;
        }

        $data = json_decode($response, true);
        //dd($data);        
        if (isset($data["places"][0])) {
            $state = $data["places"][0]["state"];
            $city = $data["places"][0]["place name"];

            // Extract state abbreviation
            $stateAbbreviation = $data["places"][0]["state abbreviation"];

            // Determine region based on state abbreviation
            $region = $stateToRegionMapping[$stateAbbreviation] ?? "-";

            return [$state, $city, $region, $stateAbbreviation];
        } else {
            // ZIP code not found
            return null;
        }
    }

    private function CheckIndiaCity($cityname)
    {


            $cityMap = [
               '1'   => 'Delhi',
    '2'   => 'Lucknow',
    '3'   => 'Kanpur',
    '4'   => 'Mumbai',
    '5'   => 'Hyderabad',
    '6'   => 'Coimbatore',
    '7'   => 'Vijayawada',
    '8'   => 'Chennai',
    '9'   => 'Agra',
    '10'  => 'Ahmedabad',
    '11'  => 'Ajmer',
    '12'  => 'Aligarh',
    '13'  => 'Allahabad',
    '14'  => 'Amravati',
    '15'  => 'Amritsar',
    '16'  => 'Asansol',
    '17'  => 'Aurangabad',
    '18'  => 'Bangalore',
    '19'  => 'Bareilly',
    '20'  => 'Belgaum',
    '21'  => 'Bhavnagar',
    '22'  => 'Bhilai',
    '23'  => 'Bhiwandi',
    '24'  => 'Bhopal',
    '25'  => 'Bhubaneswar',
    '26'  => 'Bijapur',
    '27'  => 'Bikaner',
    '28'  => 'Bilaspur',
    '29'  => 'Bokaro',
    '30'  => 'Chandigarh',
    '31'  => 'Cuttack',
    '32'  => 'Dehradun',
    '33'  => 'Dhanbad',
    '34'  => 'Dharwad',
    '35'  => 'Durgapur',
    '36'  => 'Erode',
    '37'  => 'Faridabad',
    '38'  => 'Firozabad',
    '39'  => 'Ghaziabad',
    '40'  => 'Goa',
    '41'  => 'Gorakhpur',
    '42'  => 'Gulbarga',
    '43'  => 'Guntur',
    '44'  => 'Gurgaon',
    '45'  => 'Guwahati',
    '46'  => 'Gwalior',
    '47'  => 'Hamirpur',
    '48'  => 'Hubli',
    '49'  => 'Indore',
    '50'  => 'Jabalpur',
    '51'  => 'Jaipur',
    '52'  => 'Jalandhar',
    '53'  => 'Jammu',
    '54'  => 'Jamnagar',
    '55'  => 'Jamshedpur',
    '56'  => 'Jhansi',
    '57'  => 'Jodhpur',
    '58'  => 'Kakinada',
    '59'  => 'Kannur',
    '60'  => 'Kochi',
    '61'  => 'Kolhapur',
    '62'  => 'Kolkata',
    '63'  => 'Kollam',
    '64'  => 'Kota',
    '65'  => 'Kottayam',
    '66'  => 'Kozhikode',
    '67'  => 'Kurnool',
    '68'  => 'Ludhiana',
    '69'  => 'Madurai',
    '70'  => 'Malappuram',
    '71'  => 'Mangalore',
    '72'  => 'Mathura',
    '73'  => 'Meerut',
    '74'  => 'Moradabad',
    '75'  => 'Mysore',
    '76'  => 'Nagpur',
    '77'  => 'Nanded',
    '78'  => 'Nashik',
    '79'  => 'Nellore',
    '80'  => 'Noida',
    '81'  => 'Palakkad',
    '82'  => 'Patna',
    '83'  => 'Pondicherry',
    '84'  => 'Pune',
    '85'  => 'Purulia',
    '86'  => 'Raipur',
    '87'  => 'Rajahmundry',
    '88'  => 'Rajkot',
    '89'  => 'Ranchi',
    '90'  => 'Rourkela',
    '91'  => 'Salem',
    '92'  => 'Sangli',
    '93'  => 'Shimla',
    '94'  => 'Siliguri',
    '96'  => 'Srinagar',
    '97'  => 'Solapur',
    '98'  => 'Surat',
    '99'  => 'Thiruvananthapuram',
    '100' => 'Thrissur',
    '101' => 'Tiruchirappalli',
    '102' => 'Tiruppur',
    '103' => 'Ujjain',
    '104' => 'Vadodara',
    '105' => 'Varanasi',
    '106' => 'Vasai-Virar',
    '107' => 'Vellore',
    '108' => 'Visakhapatnam',
    '109' => 'Warangal',
    '110' => 'Rest of India',
    '111' => 'Paderu',
    '112' => 'Anakapalli',
    '113' => 'Ananthapuramu',
    '114' => 'Rayachoti',
    '115' => 'Bapatla',
    '116' => 'Chittoor',
    '117' => 'Amalapuram',
    '118' => 'Rajamahendravaram',
    '119' => 'Eluru',
    '120' => 'Machilipatnam',
    '121' => 'Kurnool',
    '122' => 'Nandyal',
    '123' => 'Narasaraopet',
    '124' => 'Parvathipuram',
    '125' => 'Ongole',
    '126' => 'Srikakulam',
    '127' => 'Puttaparthi',
    '128' => 'Tirupati',
    '129' => 'Vizianagaram',
    '130' => 'Bhimavaram',
    '131' => 'Kadapa',
    '132' => 'Hawai',
    '133' => 'Changlang',
    '134' => 'Seppa',
    '135' => 'Pasighat',
    '136' => 'Raga',
    '137' => 'Palin',
    '138' => 'Koloriang',
    '139' => 'Basar',
    '140' => 'Tezu',
    '141' => 'Longding',
    '142' => 'Roing',
    '143' => 'Likabali',
    '144' => 'Ziro',
    '145' => 'Namsai',
    '146' => 'Lemmi',
    '147' => 'Yupia',
    '148' => 'Tato',
    '149' => 'Boleng',
    '150' => 'Tawang',
    '151' => 'Khonsa',
    '152' => 'Anini',
    '153' => 'Yingkiong',
    '154' => 'Daporijo',
    '155' => 'Bomdila',
    '156' => 'Aalo',
    '157' => 'Yachuli',
    '158' => 'Napangphung',
    '159' => 'Mushalpur',
    '160' => 'Pathsala',
    '161' => 'Barpeta',
    '162' => 'Biswanath Chariali',
    '163' => 'Bongaigaon',
    '164' => 'Silchar',
    '165' => 'Sonari',
    '166' => 'Kajalgaon',
    '167' => 'Mangaldoi',
    '168' => 'Dhemaji',
    '169' => 'Dhubri',
    '170' => 'Dibrugarh',
    '171' => 'Haflong',
    '172' => 'Goalpara',
    '173' => 'Golaghat',
    '174' => 'Hailakandi',
    '175' => 'Sankardev Nagar',
    '176' => 'Jorhat',
    '177' => 'Amingaon',
    '178' => 'Diphu',
    '179' => 'Karimganj',
    '180' => 'Kokrajhar',
    '181' => 'North Lakhimpur',
    '182' => 'Garamur',
    '183' => 'Marigaon',
    '184' => 'Nagaon',
    '185' => 'Nalbari',
    '186' => 'Sibsagar',
    '187' => 'Tezpur',
    '188' => 'Hatsingimari',
    '189' => 'Tamulpur',
    '190' => 'Tinsukia',
    '191' => 'Udalguri',
    '192' => 'Hamren',
    '193' => 'Araria',
    '194' => 'Arwal',
    '195' => 'Banka',
    '196' => 'Begusarai',
    '197' => 'Bhagalpur',
    '198' => 'Arrah',
    '199' => 'Buxar',
    '200' => 'Darbhanga',
    '201' => 'Motihari',
    '202' => 'Gaya',
    '203' => 'Gopalganj',
    '204' => 'Jamui',
    '205' => 'Jehanabad',
    '206' => 'Bhabua',
    '207' => 'Katihar',
    '208' => 'Khagaria',
    '209' => 'Kishanganj',
    '210' => 'Lakhisarai',
    '211' => 'Madhepura',
    '212' => 'Madhubani',
    '213' => 'Munger',
    '214' => 'Muzaffarpur',
    '215' => 'Bihar Sharif',
    '216' => 'Nawada',
    '217' => 'Purnia',
    '218' => 'Sasaram',
    '219' => 'Saharsa',
    '220' => 'Samastipur',
    '221' => 'Chhapra',
    '222' => 'Sheikhpura',
    '223' => 'Sheohar',
    '224' => 'Sitamarhi',
    '225' => 'Siwan',
    '226' => 'Supaul',
    '227' => 'Hajipur',
    '228' => 'Bettiah',
    '229' => 'Balod',
    '230' => 'Baloda Bazar',
    '231' => 'Balrampur',
    '232' => 'Jagdalpur',
    '233' => 'Bemetara',
    '234' => 'Dantewada',
    '235' => 'Dhamtari',
    '236' => 'Durg',
    '237' => 'Gariaband',
    '238' => 'Gaurela',
    '239' => 'Janjgir',
    '240' => 'Jashpur Nagar',
    '241' => 'Kawardha',
    '242' => 'Kanker',
    '243' => 'Khairagarh',
    '244' => 'Kondagaon',
    '245' => 'Korba',
    '246' => 'Baikunthpur',
    '247' => 'Mahasamund',
    '248' => 'Manendragarh',
    '249' => 'Mohla',
    '250' => 'Mungeli',
    '251' => 'Narayanpur',
    '252' => 'Raigarh',
    '253' => 'Rajnandgaon',
    '254' => 'Sarangarh',
    '255' => 'Sakti',
    '256' => 'Sukma',
    '257' => 'Surajpur',
    '258' => 'Ambikapur',
    '259' => 'Panaji',
    '260' => 'Margao',
    '261' => 'Amreli',
    '262' => 'Anand',
    '263' => 'Modasa',
    '264' => 'Palanpur',
    '265' => 'Bharuch',
    '266' => 'Botad',
    '267' => 'Chhota Udaipur',
    '268' => 'Dahod',
    '269' => 'Ahwa',
    '270' => 'Khambhalia',
    '271' => 'Gandhinagar',
    '272' => 'Veraval',
    '273' => 'Junagadh',
    '274' => 'Nadiad',
    '275' => 'Bhuj',
    '276' => 'Lunavada',
    '277' => 'Mehsana',
    '278' => 'Morbi',
    '279' => 'Rajpipla',
    '280' => 'Navsari',
    '281' => 'Godhra',
    '282' => 'Patan',
    '283' => 'Porbandar',
    '284' => 'Himatnagar',
    '285' => 'Surendranagar',
    '286' => 'Vyara',
    '287' => 'Valsad',
    '288' => 'Tharad',
    '289' => 'Ambala',
    '290' => 'Bhiwani',
    '291' => 'Charkhi Dadri',
    '292' => 'Fatehabad',
    '293' => 'Gurugram',
    '294' => 'Hisar',
    '295' => 'Jhajjar',
    '296' => 'Jind',
    '297' => 'Kaithal',
    '298' => 'Karnal',
    '299' => 'Kurukshetra',
    '300' => 'Narnaul',
     301 => "Nuh",
    302 => "Palwal",
    303 => "Panchkula",
    304 => "Panipat",
    305 => "Rewari",
    306 => "Rohtak",
    307 => "Sirsa",
    308 => "Sonipat",
    309 => "Yamunanagar",
    310 => "Bilaspur",
    311 => "Chamba",
    312 => "Hamirpur",
    313 => "Dharamshala",
    314 => "Reckong Peo",
    315 => "Kullu",
    316 => "Keylong",
    317 => "Mandi",
    318 => "Nahan",
    319 => "Solan",
    320 => "Una",
    321 => "Chatra",
    322 => "Deoghar",
    323 => "Dumka",
    324 => "Garhwa",
    325 => "Giridih",
    326 => "Godda",
    327 => "Gumla",
    328 => "Hazaribag",
    329 => "Jamtara",
    330 => "Khunti",
    331 => "Koderma",
    332 => "Latehar",
    333 => "Lohardaga",
    334 => "Pakur",
    335 => "Daltonganj",
    336 => "Ramgarh",
    337 => "Sahebganj",
    338 => "Seraikela",
    339 => "Simdega",
    340 => "Chaibasa",
    341 => "Bagalkote",
    342 => "Ballari",
    343 => "Bangalore",
    344 => "Bidar",
    345 => "Chamarajanagar",
    346 => "Chikkaballapur",
    347 => "Chikmagalur",
    348 => "Chitradurga",
    349 => "Davangere",
    350 => "Gadag-Betageri",
    351 => "Kalaburagi",
    352 => "Hassan",
    353 => "Haveri",
    354 => "Madikeri",
    355 => "Kolar",
    356 => "Koppal",
    357 => "Mandya",
    358 => "Raichur",
    359 => "Ramanagara",
    360 => "Shimoga",
    361 => "Tumakuru",
    362 => "Udupi",
    363 => "Karwar",
    364 => "Hospete",
    365 => "Bijapur",
    366 => "Yadgir",
    367 => "Alappuzha",
    368 => "Kakkanad",
    369 => "Painavu",
    370 => "Kasaragod",
    371 => "Pathanamthitta",
    372 => "Kalpetta",
    373 => "Agar",
    374 => "Alirajpur",
    375 => "Anuppur",
    376 => "Ashoknagar",
    377 => "Balaghat",
    378 => "Barwani",
    379 => "Betul",
    380 => "Bhind",
    381 => "Burhanpur",
    382 => "Chhatarpur",
    383 => "Chhindwara",
    384 => "Damoh",
    385 => "Datia",
    386 => "Dewas",
    387 => "Dhar",
    388 => "Dindori",
    389 => "Guna",
    390 => "Harda",
    391 => "Hoshangabad",
    392 => "Jhabua",
    393 => "Katni",
    394 => "Khandwa",
    395 => "Khargone",
    396 => "Maihar",
    397 => "Mandla",
    398 => "Mandsaur",
    399 => "Mauganj",
    400 => "Morena",
    401 => "Narsinghpur",
    402 => "Neemuch",
    403 => "Niwari",
    404 => "Panna",
    405 => "Pandhurna",
    406 => "Raisen",
    407 => "Rajgarh",
    408 => "Ratlam",
    409 => "Rewa",
    410 => "Sagar",
    411 => "Satna",
    412 => "Sehore",
    413 => "Seoni",
    414 => "Shahdol",
    415 => "Shajapur",
    416 => "Sheopur",
    417 => "Shivpuri",
    418 => "Sidhi",
    419 => "Waidhan",
    420 => "Tikamgarh",
    421 => "Umaria",
    422 => "Vidisha",
    423 => "Ahmednagar",
    424 => "Akola",
    425 => "Aurangabad",
    426 => "Beed",
    427 => "Bhandara",
    428 => "Buldhana",
    429 => "Chandrapur",
    430 => "Osmanabad",
    431 => "Dhule",
    432 => "Gadchiroli",
    433 => "Gondia",
    434 => "Hingoli",
    435 => "Jalgaon",
    436 => "Jalna",
    437 => "Latur",
    438 => "Bandra (East)",
    439 => "Nandurbar",
    440 => "Palghar",
    441 => "Parbhani",
    442 => "Alibag",
    443 => "Ratnagiri",
    444 => "Satara",
    445 => "Oros",
    446 => "Thane",
    447 => "Wardha",
    448 => "Washim",
    449 => "Yavatmal",
    450 => "Bishnupur",
    451 => "Chandel",
    452 => "Churachandpur",
    453 => "Porompat",
    454 => "Lamphelpat",
    455 => "Jiribam",
    456 => "Kakching",
    457 => "Kamjong",
    458 => "Kangpokpi",
    459 => "Noney (Longmai)",
    460 => "Pherzawl",
    461 => "Senapati",
    462 => "Tamenglong",
    463 => "Tengnoupal",
    464 => "Thoubal",
    465 => "Ukhrul",
    466 => "Williamnagar",
    467 => "Khliehriat",
    468 => "Shillong",
    469 => "Mairang",
    470 => "Resubelpara",
    471 => "Nongpoh",
    472 => "Baghmara",
    473 => "Ampati",
    474 => "Mawkyrwat",
    475 => "Tura",
    476 => "Jowai",
    477 => "Nongstoin",
    478 => "Aizawl",
    479 => "Champhai",
    480 => "Hnahthial",
    481 => "Khawzawl",
    482 => "Kolasib",
    483 => "Lawngtlai",
    484 => "Lunglei",
    485 => "Mamit",
    486 => "Saiha",
    487 => "Saitual",
    488 => "Serchhip",
    489 => "Chufcmoukedima",
    490 => "Dimapur",
    491 => "Kiphire",
    492 => "Kohima",
    493 => "Longleng",
    494 => "Mokokchung",
    495 => "Mon",
    496 => "Niuland",
    497 => "Noklak",
    498 => "Peren",
    499 => "Phek",
    500 => "Shamator",
    501 => "Tseminyu",
    502 => "Tuensang",
    503 => "Wokha",
    504 => "Zunheboto",
    505 => "Angul",
    506 => "Boudh",
    507 => "Bhadrak",
    508 => "Balangir",
    509 => "Bargarh",
    510 => "Balasore",
    511 => "Debagarh",
    512 => "Dhenkanal",
    513 => "Chhatrapur",
    514 => "Paralakhemundi",
    515 => "Jharsuguda",
    516 => "Jajpur",
    517 => "Jagatsinghpur",
    518 => "Khordha",
    519 => "Kendujhar",
    520 => "Phulbani",
    521 => "Koraput",
    522 => "Kendrapara",
    523 => "Malkangiri",
    524 => "Baripada",
    525 => "Nabarangpur",
    526 => "Nuapada",
    527 => "Nayagarh",
    528 => "Puri",
    529 => "Rayagada",
    530 => "Sambalpur",
    531 => "Subarnapur",
    532 => "Sundergarh",
    533 => "Barnala",
    534 => "Bathinda",
    535 => "Faridkot",
    536 => "Fatehgarh Sahib",
    537 => "Fazilka",
    538 => "Firozpur",
    539 => "Gurdaspur",
    540 => "Hoshiarpur",
    541 => "Kapurthala",
    542 => "Malerkotla",
    543 => "Mansa",
    544 => "Moga",
    545 => "Pathankot",
    546 => "Patiala",
    547 => "Rupnagar",
    548 => "Sahibzada Ajit Singh Nagar",
    549 => "Sangrur",
    550 => "Nawanshahr",
    551 => "Sri Muktsar Sahib",
    552 => "Tarn Taran Sahib",
    553 => "Alwar",
    554 => "Balotra",
    555 => "Banswara",
    556 => "Baran",
    557 => "Barmer",
    558 => "Beawar",
    559 => "Bharatpur",
    560 => "Bhilwara",
    561 => "Bundi",
    562 => "Chittorgarh",
    563 => "Churu",
    564 => "Dausa",
    565 => "Deeg",
    566 => "Dholpur",
    567 => "Didwana",
    568 => "Dungarpur",
    569 => "Hanumangarh",
    570 => "Jaisalmer",
    571 => "Jalore",
    572 => "Jhalawar",
    573 => "Jhunjhunu",
    574 => "Karauli",
    575 => "Khairthal",
    576 => "Kotputli",
    577 => "Nagaur",
    578 => "Pali",
    579 => "Phalodi",
    580 => "Pratapgarh",
    581 => "Rajsamand",
    582 => "Salumbar",
    583 => "Sawai Madhopur",
    584 => "Sikar",
    585 => "Sirohi",
    586 => "Sri Ganganagar",
    587 => "Tonk",
    588 => "Udaipur",
    589 => "Gangtok",
    590 => "Gyalshing",
    591 => "Mangan",
    592 => "Namchi",
    593 => "Pakyong",
    594 => "Soreng",
    595 => "Ariyalur",
    596 => "Chengalpattu",
    597 => "Cuddalore",
    598 => "Dharmapuri",
    599 => "Dindigul",
    600 => "Kallakurichi",
    601 => "Kanchipuram",
    602 => "Nagercoil",
    603 => "Karur",
    604 => "Krishnagiri",
    605 => "Mayiladuthurai",
    606 => "Nagapattinam",
    607 => "Ooty",
    608 => "Namakkal",
    609 => "Perambalur",
    610 => "Pudukkottai",
    611 => "Ramanathapuram",
    612 => "Ranipettai",
    613 => "Sivagangai",
    614 => "Tenkasi",
    615 => "Theni",
    616 => "Tirunelveli",
    617 => "Thanjavur",
    618 => "Thoothukudi",
    619 => "Tirupattur",
    620 => "Tiruvallur",
    621 => "Thiruvarur",
    622 => "Tiruvannaamalai",
    623 => "Viluppuram",
    624 => "Virudhunagar",
    625 => "Adilabad",
    626 => "Kothagudem",
    627 => "Hanamkonda",
    628 => "Jagtial",
    629 => "Jangaon",
    630 => "Bhupalpally",
    631 => "Gadwal",
    632 => "Kamareddy",
    633 => "Karimnagar",
    634 => "Khammam",
    635 => "Asifabad",
    636 => "Mahabubabad",
    637 => "Mahbubnagar",
    638 => "Mancherial",
    639 => "Medak",
    640 => "Shamirpet",
    641 => "Mulugu",
    642 => "Nalgonda",
    643 => "Narayanpet",
    644 => "Nirmal",
    645 => "Nizamabad",
    646 => "Peddapalli",
    647 => "Sircilla",
    648 => "Hyderabad",
    649 => "Sangareddy",
    650 => "Siddipet",
    651 => "Suryapet",
    652 => "Vikarabad",
    653 => "Wanaparthy",
    654 => "Bhongir",
    655 => "Ambassa",
    656 => "Udaipur",
    657 => "Khowai",
    658 => "Dharmanagar",
    659 => "Bishramganj",
    660 => "Belonia",
    661 => "Kailashahar",
    662 => "Agartala",
    663 => "Akbarpur",
    664 => "Gauriganj",
    665 => "Amroha",
    666 => "Auraiya",
    667 => "Ayodhya",
    668 => "Azamgarh",
    669 => "Baghpat",
    670 => "Bahraich",
    671 => "Ballia",
    672 => "Balrampur",
    673 => "Banda",
    674 => "Barabanki",
    675 => "Basti",
    676 => "Gyanpur",
    677 => "Bijnor",
    678 => "Budaun",
    679 => "Bulandshahr",
    680 => "Chandauli",
    681 => "Karwi",
    682 => "Deoria",
    683 => "Etah",
    684 => "Etawah",
    685 => "Fatehgarh",
    686 => "Fatehpur",
    687 => "Ghazipur",
    688 => "Gonda",
    689 => "Hapur",
    690 => "Hardoi",
    691 => "Hathras",
    692 => "Orai",
    693 => "Jaunpur",
    694 => "Kannauj",
    695 => "Kanpur",
    696 => "Kasganj",
    697 => "Manjhanpur",
    698 => "Padrauna",
    699 => "Lakhimpur",
    700 => "Lalitpur",
    701 => "Maharajganj",
    702 => "Mahoba",
    703 => "Mainpuri",
    704 => "Mau",
    705 => "Mirzapur",
    706 => "Muzaffarnagar",
    707 => "Pilibhit",
    708 => "Pratapgarh",
    709 => "Prayagraj",
    710 => "Raebareli",
    711 => "Rampur",
    712 => "Saharanpur",
    713 => "Sambhal",
    714 => "Khalilabad",
    715 => "Shahjahanpur",
    716 => "Shamli",
    717 => "Shravasti",
    718 => "Naugarh",
    719 => "Sitapur",
    720 => "Robertsganj",
    721 => "Sultanpur",
    722 => "Unnao",
    723 => "Almora",
    724 => "Bageshwar",
    725 => "Gopeshwar",
    726 => "Champawat",
    727 => "Haridwar",
    728 => "Nainital",
    729 => "Pauri",
    730 => "Pithoragarh",
    731 => "Rudraprayag",
    732 => "New Tehri",
    733 => "Rudrapur",
    734 => "Uttarkashi",
    735 => "Alipurduar",
    736 => "Bankura",
    737 => "Suri",
    738 => "Cooch Behar",
    739 => "Balurghat",
    740 => "Darjeeling",
    741 => "Chinsurah",
    742 => "Howrah",
    743 => "Jalpaiguri",
    744 => "Jhargram",
    745 => "Kalimpong",
    746 => "English Bazar",
    747 => "Baharampur",
    748 => "Krishnanagar",
    749 => "Barasat",
    750 => "Midnapore",
    751 => "Bardhaman",
    752 => "Tamluk",
    753 => "Alipore",
    754 => "Raiganj",
    755 => "Car Nicobar",
    756 => "Mayabunder",
    757 => "Port Blair",
    758 => "Silvassa",
    759 => "Daman",
    760 => "Diu",
    761 => "Budgam",
    762 => "Bandipore",
    763 => "Baramulla",
    764 => "Doda",
    765 => "Ganderbal",
    766 => "Jammu",
    767 => "Kathua",
    768 => "Kishtwar",
    769 => "Kulgam",
    770 => "Kupwara",
    771 => "Poonch",
    772 => "Pulwama",
    773 => "Rajouri",
    774 => "Ramban",
    775 => "Reasi",
    776 => "Samba",
    777 => "Shopian",
    778 => "Udhampur",
    779 => "Kargil",
    780 => "Leh",
    781 => "Kavaratti",
    782 => "Karaikal",
    783 => "Mahe",
    784 => "Yanam"
            ];
            if(array_search($cityname, $cityMap)){
              $key=array_search($cityname, $cityMap); 
              return $key;
            }else{
                 $key=110;
                return 110;
            }
    }

private function CheckIndiaState($statename)
    {


            $states = [
    '1'  => 'Andhra Pradesh',
    '2'  => 'Arunachal Pradesh',
    '3'  => 'Assam',
    '4'  => 'Bihar',
    '5'  => 'Chhattisgarh',
    '6'  => 'Goa',
    '7'  => 'Gujarat',
    '8'  => 'Haryana',
    '9'  => 'Himachal Pradesh',
    '10' => 'Jammu and Kashmir',
    '11' => 'Jharkhand',
    '12' => 'Karnataka',
    '13' => 'Kerala',
    '14' => 'Madhya Pradesh',
    '15' => 'Maharashtra',
    '16' => 'Manipur',
    '17' => 'Meghalaya',
    '18' => 'Mizoram',
    '19' => 'Nagaland',
    '20' => 'Odisha',
    '21' => 'Punjab',
    '22' => 'Rajasthan',
    '23' => 'Sikkim',
    '24' => 'Tamil Nadu',
    '25' => 'Tripura',
    '26' => 'Uttar Pradesh',
    '27' => 'Uttarakhand',
    '28' => 'West Bengal',
    '29' => 'Andaman and Nicobar',
    '30' => 'Chandigarh',
    '31' => 'Dadra and Nagar Haveli and Daman and Diu (DD)',
    '32' => 'Ladakh',
    '33' => 'Lakshadweep',
    '34' => 'Puducherry',
];
            if(array_search($statename, $states)){
              $key=array_search($statename, $states); 
              return $key;
            }else{
                 $key=0;
                return 0;
            }
    }
}
