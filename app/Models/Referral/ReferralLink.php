<?php

namespace App\Models\Referral;

use App\Models\Auth\User;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used to store the referral link as the user send invitation links or invites by the Invite Form.
 *
 * Class ReferralLink
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Referral\ReferralLink
 */

class ReferralLink extends Model
{
    protected $fillable = ['user_id', 'referral_program_id'];

    /**
     * This function is used for creating random code for the particular referral links  as the user sends the Invitation.
     */
    protected static function boot()
    {
        parent::boot();
        //while creating/inserting item into db
        static::creating(function (ReferralLink $model) {
            $model->code = (string) Uuid::generate();
        });
    }

    private function generateCode()
    {
        $this->code = (string)Uuid::generate();
    }


    /**
     * This function is used for creating or fetching creating referral links for a particular user.
     *
     * @param $user
     * @param $program
     * @return mixed
     */
    public static function getReferral($user, $program)
    {
        return static::firstOrCreate([
            'user_id' => $user->id,
            'referral_program_id' => $program->id
        ]);
    }

    /**
     * This function is used for getting the random code generated in referral links table and than saving it in cookies.
     * 
     * @return string
     */
    public function getLinkAttribute($method=null,$Referral=null)
    {
        return route('inpanel.myrefer.show', ['code' => $this->code,'m'=>$method,'ref'=>$Referral]);
        // return route('inpanel.myrefer.show', ['code' => $this->code]);
        // return url($this->program->uri) . '?ref=' . $this->code;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        // TODO: Check if second argument is required
        return $this->belongsTo(ReferralProgram::class, 'referral_program_id');
    }

    public function relationships()
    {
        return $this->hasMany(ReferralRelationship::class);
    }

}
