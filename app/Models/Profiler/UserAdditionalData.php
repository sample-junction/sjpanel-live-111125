<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 12-03-2019
 * Time: 01:43 AM
 */

namespace App\Models\Profiler;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

/**
 * This modal class is storing all the data of the user like basic details,detailed profile,
 * tour taken, points achieved,points redeemed.
 *
 * Class UserAdditionalData
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Profiler\UserAdditionalData
 */

class UserAdditionalData extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'user_additional_data';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        '_id',
        'uuid',
        'u_id',
        'user_answers',
        'user_points',
        'user_additional_info',
        'user_achievement',
        'user_filled_profiles',
    ];

    public static $answersProjectionArray = [
        '_id' => true,
        'uuid' => true,
        'u_id' => true,
        'user_answers' => true,
    ];

    /**
     * This function is used for making projection of getting Answer for the particular profile section code or
     * for the particular question_code.
     *
     * @param null $profile_code
     * @param null $question_code
     * @return array
     */
    public static function getAnswersProjectionArray( $profile_code = null, $question_code = null )
    {
        $projectionArray = self::$answersProjectionArray;

        if( !empty($profile_code) ){
            $projectionArray['user_answers'] = [
                '$elemMatch' => [
                    'profile_section_code' => "$profile_code"
                ]
            ];
        }
        if( !empty($question_code) ){
            $projectionArray['user_answers']['$elemMatch']['profile_question_code'] = "$question_code";
        }

        return $projectionArray;
    }
}
