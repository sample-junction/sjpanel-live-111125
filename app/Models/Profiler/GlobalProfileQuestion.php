<?php

namespace App\Models\Profiler;

use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

/**
 * This modal class is used for saving all the global_profile_questions for all our active countries.
 *
 * Class GlobalProfileQuestion
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Profiler\GlobalProfileQuestion
 */

class GlobalProfileQuestion extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'global_question_master';
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

    /**
     * This function is used for finding questions by id.
     * @param $question_id
     * @return mixed
     */
    public static function findById($question_id)
    {
        return self::where('id', $question_id)->first();
    }

    /**
     * This function is used for creating relationship by profile_section_id of GlobalProfileQuestion to _id of ProfileSection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(ProfileSection::class, '_id', 'profile_section_id' );
    }
}
