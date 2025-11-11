<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 11-03-2019
 * Time: 06:49 PM
 */

namespace App\Models\Profiler;

use App\Models\Profiler\Traits\Method\ProfilerTranslator;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

/**
 * This modal class is used for storing and fetching all the profile questions of all the active countries.
 *
 * Class ProfilerQuestions
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Profiler\ProfilerQuestions
 */

class ProfilerQuestions extends Eloquent
{
    use ProfilerTranslator;

    protected $connection = 'mongodb';
    protected $table = 'profile_question_master';
    /**
     * @var array $fillable
     */
    protected $fillable = [
        '_id',
        'id',
        'q_id',
        'general_name',
        'display_name',
        'country_code',
        'dependency',
        'order',
        'type',
        'show_as',
        'profile_section_id',
        'profile_section_code',
        'profile_section',
        'translated',
        'updated_at',
        'created_at',
    ];

    public static $projectionArray = [
        '_id' => true,
        'id' => true,
        'q_id' => true,
        'general_name' => true,
        'display_name' => true,
        'country_code' => true,
        'order' => true,
        'type' => true,
        'show_as' => true,
        'dependency' => true,
        'spl_quest' =>  true,
        'profile_section_id' => true,
        'profile_section' => true,
        'translated' => true,
        'updated_at' => true,
        'created_at' => true,
    ];

    /**
     * This function is used to create projection for fetching data by mongoDB queries for fetching Single Question, Next Question
     * Save and Fetch next questions.
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

    /**
     * This function is used for finding the question by its id.
     *
     * @param $question_id
     * @return mixed
     */
    public static function findById($question_id)
    {
        return self::where('id', $question_id)->first();
    }

    /**
     * This function is used for making relationship for profile_section_id of ProfilerQuestions with _id of ProfileSection
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(ProfileSection::class, '_id', 'profile_section_id' );
    }
}
