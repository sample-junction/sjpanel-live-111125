<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestApiController extends Controller
{
    //
    public function testApiResponse()
    {
        return response()->json([
            [
                "cpi"=> 2,
                "id"=> 63,
                "locale"=> "pt-BR",
                "loi"=> 0,
                "name"=> "Brazil Mom Survey",
                "qualifications"=> [
                    [
                        "options"=> [
                            "boy_age_10",
                            "boy_age_5",
                            "boy_age_6",
                            "boy_age_7",
                            "boy_age_8",
                            "boy_age_9",
                            "girl_age_10",
                            "girl_age_5",
                            "girl_age_6",
                            "girl_age_7",
                            "girl_age_8",
                            "girl_age_9"
                        ],
                        "question"=> "child_age_and_gender",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "21-49"
                        ],
                        "question"=> "age",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "female"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 350,
                "remaining_type"=> "completes",
                "token"=> "7ygXLB",
                "url"=> "https://staging.itrafficcenter.com/survey/63/50/%respondent_id%?token=7ygXLB"
            ],
            [
                "cpi"=> 3,
                "id"=> 164,
                "ir"=> 100,
                "locale"=> "ja-JP",
                "loi"=> 1,
                "name"=> "Test_China_1",
                "qualifications"=> [
                    [
                        "options"=> [
                            "1",
                            "101_to_500",
                            "11_to_50",
                            "2_to_10",
                            "501_to_1000",
                            "51_to_100"
                        ],
                        "question"=> "standard_number_of_employees",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "income_band_10",
                            "income_band_11",
                            "income_band_12",
                            "income_band_13",
                            "income_band_14",
                            "income_band_15",
                            "income_band_16",
                            "income_band_17",
                            "income_band_9"
                        ],
                        "question"=> "income",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "30-65"
                        ],
                        "question"=> "age",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "employed_full_time",
                            "employed_part_time",
                            "self_employed_full_time",
                            "self_employed_part_time"
                        ],
                        "question"=> "employment_status",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "own_apartment",
                            "own_house"
                        ],
                        "question"=> "residence",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "high_school_grad",
                            "middle_school",
                            "some_high_school",
                            "vocational_training"
                        ],
                        "question"=> "education",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "female"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "1",
                                    "11_to_50",
                                    "2_to_10",
                                    "51_to_100"
                                ],
                                "question"=> "standard_number_of_employees",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 10
                    ],
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "101_to_500",
                                    "501_to_1000"
                                ],
                                "question"=> "standard_number_of_employees",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 10
                    ]
                ],
                "remaining"=> 30,
                "remaining_type"=> "starts",
                "token"=> "VybYqG",
                "url"=> "https://staging.itrafficcenter.com/survey/164/50/%respondent_id%?token=VybYqG"
            ],
            [
                "cpi"=> 4,
                "id"=> 256,
                "ir"=> 100,
                "locale"=> "en-IN",
                "loi"=> 1,
                "name"=> "India Survey",
                "qualifications"=> [
                    [
                        "options"=> [
                            "18-99"
                        ],
                        "question"=> "age",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "male"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 70,
                "remaining_type"=> "completes",
                "token"=> "MGAr0y",
                "url"=> "https://staging.itrafficcenter.com/survey/256/50/%respondent_id%?token=MGAr0y"
            ],
            [
                "cpi"=> 2,
                "id"=> 575,
                "ir"=> 3,
                "locale"=> "fr-CA",
                "loi"=> 7,
                "name"=> "fr ca screening",
                "qualifications"=> [
                    [
                        "options"=> [
                            "19-77"
                        ],
                        "question"=> "age",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 997,
                "remaining_type"=> "starts",
                "token"=> "0Bxgpy",
                "url"=> "https://staging.itrafficcenter.com/survey/575/50/%respondent_id%?token=0Bxgpy"
            ],
            [
                "cpi"=> 1,
                "id"=> 602,
                "ir"=> 10,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "s-name",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 94,
                "remaining_type"=> "starts",
                "token"=> "6yDokG",
                "url"=> "https://staging.itrafficcenter.com/survey/602/50/%respondent_id%?token=6yDokG"
            ],
            [
                "cpi"=> 1,
                "id"=> 603,
                "ir"=> 10,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "name tre",
                "qualifications"=> [
                    [
                        "options"=> [
                            "green_party",
                            "independent",
                            "other",
                            "republican"
                        ],
                        "question"=> "political_affiliation",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "green_party",
                                    "independent",
                                    "other",
                                    "republican"
                                ],
                                "question"=> "political_affiliation",
                                "type"=> "or"
                            ],
                            [
                                "options"=> [
                                    "female",
                                    "male"
                                ],
                                "question"=> "gender",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 565656
                    ]
                ],
                "remaining"=> 341,
                "remaining_type"=> "starts",
                "token"=> "pBLomy",
                "url"=> "https://staging.itrafficcenter.com/survey/603/50/%respondent_id%?token=pBLomy"
            ],
            [
                "cpi"=> 1,
                "id"=> 604,
                "ir"=> 10,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "sdfasdf",
                "qualifications"=> [
                    [
                        "options"=> [
                            "1",
                            "1001_to_5000",
                            "101_to_500",
                            "11_to_50",
                            "2_to_10",
                            "501_to_1000",
                            "51_to_100",
                            "greater_than_5000",
                            "i_do_not_work_or_know"
                        ],
                        "question"=> "standard_number_of_employees",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 95,
                "remaining_type"=> "starts",
                "token"=> "qG1YzG",
                "url"=> "https://staging.itrafficcenter.com/survey/604/50/%respondent_id%?token=qG1YzG"
            ],
            [
                "cpi"=> 1,
                "id"=> 607,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "test-gb",
                "qualifications"=> [
                    [
                        "options"=> [
                            "10023"
                        ],
                        "question"=> "zip_code",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "asian_or_asian_american",
                            "black_or_african_american",
                            "middle_eastern",
                            "native_american_or_indian_American",
                            "other_ethnicity",
                            "prefer_not_to_say",
                            "white_or_caucasian"
                        ],
                        "question"=> "race",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 993,
                "remaining_type"=> "starts",
                "token"=> "ZGzPkB",
                "url"=> "https://staging.itrafficcenter.com/survey/607/50/%respondent_id%?token=ZGzPkB"
            ],
            [
                "cpi"=> 1,
                "id"=> 608,
                "ir"=> 100,
                "locale"=> "zh-CN",
                "loi"=> 10,
                "name"=> "China FP guard",
                "qualifications"=> [
                    [
                        "options"=> [
                            "18-99"
                        ],
                        "question"=> "age",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "18-45"
                                ],
                                "question"=> "age",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 98
                    ]
                ],
                "remaining"=> 297,
                "remaining_type"=> "starts",
                "token"=> "jBKo0B",
                "url"=> "https://staging.itrafficcenter.com/survey/608/50/%respondent_id%?token=jBKo0B"
            ],
            [
                "cpi"=> 1,
                "id"=> 609,
                "ir"=> 100,
                "locale"=> "es-CL",
                "loi"=> 10,
                "name"=> "ip",
                "qualifications"=> [
                    [
                        "options"=> [
                            "5-90"
                        ],
                        "question"=> "age",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 0,
                "remaining_type"=> "starts",
                "token"=> "Xya1ay",
                "url"=> "https://staging.itrafficcenter.com/survey/609/50/%respondent_id%?token=Xya1ay"
            ],
            [
                "cpi"=> 1,
                "id"=> 612,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 1,
                "name"=> "in-pg",
                "qualifications"=> [
                    [
                        "options"=> [
                            "not_hispanic_latino_or_spanish",
                            "prefer_not_to_answer",
                            "yes_cuban",
                            "yes_from_argentina",
                            "yes_from_colombia",
                            "yes_from_ecuador",
                            "yes_from_el_salvador",
                            "yes_from_guatemala",
                            "yes_from_nicaragua",
                            "yes_from_panama",
                            "yes_from_peru",
                            "yes_from_spain",
                            "yes_from_venezuela",
                            "yes_mexican",
                            "yes_other",
                            "yes_puerto_rican"
                        ],
                        "question"=> "hispanic",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "midwest",
                            "northeast",
                            "south",
                            "west"
                        ],
                        "question"=> "region",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "asian_or_asian_american",
                            "black_or_african_american",
                            "middle_eastern",
                            "native_american_or_indian_American",
                            "other_ethnicity",
                            "prefer_not_to_say",
                            "white_or_caucasian"
                        ],
                        "question"=> "race",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "0-80"
                        ],
                        "question"=> "age",
                        "type"=> "or"
                    ],
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "male"
                                ],
                                "question"=> "gender",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 0
                    ],
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "0-75"
                                ],
                                "question"=> "age",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 0
                    ],
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "asian_or_asian_american",
                                    "black_or_african_american",
                                    "middle_eastern",
                                    "native_american_or_indian_American",
                                    "other_ethnicity",
                                    "prefer_not_to_say",
                                    "white_or_caucasian"
                                ],
                                "question"=> "race",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 0
                    ],
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "midwest",
                                    "northeast",
                                    "south",
                                    "west"
                                ],
                                "question"=> "region",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 0
                    ],
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "not_hispanic_latino_or_spanish",
                                    "prefer_not_to_answer",
                                    "yes_cuban",
                                    "yes_from_argentina",
                                    "yes_from_colombia",
                                    "yes_from_ecuador",
                                    "yes_from_el_salvador",
                                    "yes_from_guatemala",
                                    "yes_from_nicaragua",
                                    "yes_from_panama",
                                    "yes_from_peru",
                                    "yes_from_spain",
                                    "yes_from_venezuela",
                                    "yes_mexican",
                                    "yes_other",
                                    "yes_puerto_rican"
                                ],
                                "question"=> "hispanic",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 0
                    ]
                ],
                "remaining"=> 98,
                "remaining_type"=> "starts",
                "token"=> "MGA7ZB",
                "url"=> "https://staging.itrafficcenter.com/survey/612/50/%respondent_id%?token=MGA7ZB"
            ],
            [
                "cpi"=> 1,
                "id"=> 613,
                "ir"=> 100,
                "locale"=> "es-ES",
                "loi"=> 1,
                "name"=> "no-abd",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "female"
                                ],
                                "question"=> "gender",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 2
                    ]
                ],
                "remaining"=> 10,
                "remaining_type"=> "completes",
                "token"=> "myEoD3",
                "url"=> "https://staging.itrafficcenter.com/survey/613/50/%respondent_id%?token=myEoD3"
            ],
            [
                "cpi"=> 1.5,
                "id"=> 614,
                "ir"=> 5,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "s-test",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 97,
                "remaining_type"=> "starts",
                "token"=> "4y4pny",
                "url"=> "https://staging.itrafficcenter.com/survey/614/50/%respondent_id%?token=4y4pny"
            ],
            [
                "cpi"=> 1.25,
                "id"=> 633,
                "ir"=> 90,
                "locale"=> "en-US",
                "loi"=> 25,
                "name"=> "ThomasExternal1_16_25c_cloned",
                "qualifications"=> [
                    [
                        "options"=> [
                            "1-99"
                        ],
                        "question"=> "age",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 992,
                "remaining_type"=> "starts",
                "token"=> "2Bn7Y3",
                "url"=> "https://staging.itrafficcenter.com/survey/633/50/%respondent_id%?token=2Bn7Y3"
            ],
            [
                "cpi"=> 1.25,
                "id"=> 636,
                "ir"=> 90,
                "locale"=> "en-US",
                "loi"=> 25,
                "name"=> "ThomasExternal1_16_25c_cloned_2",
                "qualifications"=> [
                    [
                        "options"=> [
                            "associate_degree",
                            "bachelor_degree",
                            "doctoral_degree",
                            "high_school_grad",
                            "master_degree",
                            "middle_school",
                            "some_college",
                            "some_graduate",
                            "some_high_school",
                            "third_grade_or_less",
                            "vocational_training"
                        ],
                        "question"=> "education",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 995,
                "remaining_type"=> "starts",
                "token"=> "EyZOjB",
                "url"=> "https://staging.itrafficcenter.com/survey/636/50/%respondent_id%?token=EyZOjB"
            ],
            [
                "cpi"=> 3.5,
                "id"=> 637,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "Survey 1 for IP fix",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 991,
                "remaining_type"=> "starts",
                "token"=> "lG05py",
                "url"=> "https://staging.itrafficcenter.com/survey/637/50/%respondent_id%?token=lG05py"
            ],
            [
                "cpi"=> 4.5,
                "id"=> 638,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "Survey 1 for IP fix_clone",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 999,
                "remaining_type"=> "starts",
                "token"=> "g36glG",
                "url"=> "https://staging.itrafficcenter.com/survey/638/50/%respondent_id%?token=g36glG"
            ],
            [
                "cpi"=> 9.5,
                "id"=> 639,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "Survey 1 for IP fix_clone",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 989,
                "remaining_type"=> "starts",
                "token"=> "93Y1Q3",
                "url"=> "https://staging.itrafficcenter.com/survey/639/50/%respondent_id%?token=93Y1Q3"
            ],
            [
                "cpi"=> 1.5,
                "id"=> 641,
                "ir"=> 5,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "adhoc-test-link",
                "qualifications"=> [
                    [
                        "options"=> [
                            "male"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 94,
                "remaining_type"=> "starts",
                "token"=> "J3oAwy",
                "url"=> "https://staging.itrafficcenter.com/survey/641/50/%respondent_id%?token=J3oAwy"
            ],
            [
                "cpi"=> 1,
                "id"=> 642,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "test_ws",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 79,
                "remaining_type"=> "starts",
                "token"=> "MyP5WB",
                "url"=> "https://staging.itrafficcenter.com/survey/642/50/%respondent_id%?token=MyP5WB"
            ],
            [
                "cpi"=> 1,
                "id"=> 643,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "test_ws_clone",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [],
                "remaining"=> 90,
                "remaining_type"=> "starts",
                "token"=> "13qWmy",
                "url"=> "https://staging.itrafficcenter.com/survey/643/50/%respondent_id%?token=13qWmy"
            ],
            [
                "cpi"=> 1,
                "id"=> 644,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "survey-idemp-1",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "female",
                                    "male"
                                ],
                                "question"=> "gender",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 8
                    ]
                ],
                "remaining"=> 98,
                "remaining_type"=> "starts",
                "token"=> "MBkKEB",
                "url"=> "https://staging.itrafficcenter.com/survey/644/50/%respondent_id%?token=MBkKEB"
            ],
            [
                "cpi"=> 1,
                "id"=> 645,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "survey-idemp-2",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "female",
                                    "male"
                                ],
                                "question"=> "gender",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 10
                    ]
                ],
                "remaining"=> 100,
                "remaining_type"=> "starts",
                "token"=> "4BRPZG",
                "url"=> "https://staging.itrafficcenter.com/survey/645/50/%respondent_id%?token=4BRPZG"
            ],
            [
                "cpi"=> 1,
                "id"=> 646,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "survey-idemp-3",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "female",
                                    "male"
                                ],
                                "question"=> "gender",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 8
                    ]
                ],
                "remaining"=> 98,
                "remaining_type"=> "starts",
                "token"=> "6yD7kG",
                "url"=> "https://staging.itrafficcenter.com/survey/646/50/%respondent_id%?token=6yD7kG"
            ],
            [
                "cpi"=> 1,
                "id"=> 647,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "exc_group_1_survey",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "female",
                                    "male"
                                ],
                                "question"=> "gender",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 9
                    ]
                ],
                "remaining"=> 99,
                "remaining_type"=> "starts",
                "token"=> "pBL5m3",
                "url"=> "https://staging.itrafficcenter.com/survey/647/50/%respondent_id%?token=pBL5m3"
            ],
            [
                "cpi"=> 1,
                "id"=> 648,
                "ir"=> 100,
                "locale"=> "en-US",
                "loi"=> 10,
                "name"=> "exc_group_2_survey",
                "qualifications"=> [
                    [
                        "options"=> [
                            "female",
                            "male",
                            "non_binary"
                        ],
                        "question"=> "gender",
                        "type"=> "or"
                    ]
                ],
                "quotas"=> [
                    [
                        "conditions"=> [
                            [
                                "options"=> [
                                    "female",
                                    "male"
                                ],
                                "question"=> "gender",
                                "type"=> "or"
                            ]
                        ],
                        "remaining"=> 10
                    ]
                ],
                "remaining"=> 100,
                "remaining_type"=> "starts",
                "token"=> "qG1gzB",
                "url"=> "https://staging.itrafficcenter.com/survey/648/50/%respondent_id%?token=qG1gzB"
            ]
        ]);
    }
}
