<?php

namespace App\Models\Profiler;

use App\Models\Profiler\Traits\Scope\ProfileSectionScope;
use App\Models\Profiler\Traits\Method\ProfilerTranslator;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * This modal class is used for storing all the profile section details for all the active countries.
 *
 * Class ProfileSection
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Profiler\ProfileSection
 */

class ProfileSection extends Eloquent
{

    protected $connection = 'mongodb';
    protected $collection = 'profile_sections_master';

    use ProfileSectionScope, ProfilerTranslator;

    /**
     * @var array $fillable
     */
    protected $fillable = [
        '_id',
        'general_name',
        'display_name',
        'type',
        'completion_time',
        'points',
        'status',
        'order',
        'translated',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public static $projectionArray = [
        '_id' => true,
        'general_name' => true,
        'display_name' => true,
        'type' => true,
        'completion_time' => true,
        'points' => true,
        'status' => true,
        'order' => true,
        'translated' => true,
        'created_at' => true,
        'updated_at' => true,
    ];

    /**
     * This function is used for getting projection array for using it in query of mongoDB in different functions
     *
     * @param $country_code
     * @param $language_code
     * @return array
     */
    public static function getProjectionArray($country_code, $language_code)
    {
        $projectionArray = self::$projectionArray;
        $projectionArray['translated'] = [
            '$elemMatch' => ['con_lang' => "$country_code-$language_code"]
        ];
        return $projectionArray;
    }

    /*public function questions()
    {
        return $this->embedsMany(ProfilerQuestions::class, '_id', 'profile_section_id');
    }*/

    /**
     * This function is used make relationship with profile_section_id of ProfileSection & _id of ProfileQuestions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ques()
    {
        return $this->hasMany(ProfilerQuestions::class, 'profile_section_id', '_id');
    }
}
