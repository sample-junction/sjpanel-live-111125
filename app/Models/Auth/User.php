<?php

namespace App\Models\Auth;

use App\Models\Auth\Traits\Encryptable;
use App\Models\Auth\Traits\Scope\UserUnsubscribe;
use App\Models\Country;
use App\Models\CountryTrans;
use App\Models\Traits\Uuid;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\Traits\SendUserPasswordReset;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\Traits\Relationship\UserRelationship;
use Webpatser\Uuid\Uuid as PackageUuid;
use App\Models\Auth\Traits\AchievementsTrait;
use App\Models\Redeem\RequestRedeem;
use App\Models\Auth\PanellistAddress;
use App\Models\StoredImage;

/**
 * This modal class is used storing,inserting & fetching users data.
 *
 * Class User
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Auth\User
 */

class User extends Authenticatable
{
    use HasRoles,
        Notifiable,
        SendUserPasswordReset,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        Uuid,
        AchievementsTrait,
        UserUnsubscribe,
        Encryptable;

    protected $encryptable = [
        'first_name','last_name','middle_name','email','gender','zipcode','ip_registered_with','fb','twitter','linkdin','instagram',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'panellist_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'email_hash',
        'avatar_type',
        'avatar_location',
        'password',
        'password_changed_at',
        'gender',
        'dob',
        'zipcode',
        'locale',
        'country',
        'country_code',
        'avatar_type',
        'avatar_location',
        'is_social',
        'filled_basic_details',
        'detailed_profile_filled',
        'ip_registered_with',
        'active',
        'confirmation_code',
        'confirmed',
        'tour_taken',
        'image_url',
        'timezone',
        'last_login_at',
        'unsubscribed',
        'is_blacklist',
        'last_login_ip',
        'api_token',
        'google2fa_secret',
        'two_fact_auth',
        'two_fact_confirm',
        'user_group',
        'device_preference',
        'email_ratio',
        'mail_sent_at',
        'count_mail_sent',
        'profile_updatetoken',
        'profile_updatetoken_date',
        'deactivate_at',
        'deactivate_reason',
        'delete_reason',
        'confirm_at',
        'fb',
        'linkdin',
        'twitter',
        'home_country',
        'social_email'
      
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    /**
     * This function is used for updating country_code and UUID in User Table during create and update in Users Table.
     */
    protected static function boot()
    {
        parent::boot();
        //while creating/inserting item into db
        static::creating(function (User $model) {
            $model->createCountryCode();
            $model->{$model->getUuidName()} = PackageUuid::generate(4)->string;
        });
        static::updating(function (User $model) {
            $model->createCountryCode();
        });
    }

    private function createCountryCode()
    {
        if(!empty($this->country)){
            if($this->country=='GB'){
                $country = CountryTrans::where("country_code","=",'UK')->first();
            }else{
                $country = CountryTrans::where("country_code","=",$this->country)->first();
            }

            $this->country_code = $country->country_code;
        }
    }

    /**
     * This function is used to get current User Is.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * This function is used for getting current user UUID.
     *
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    public static function getPanelistsId($uuid) {
        //$userData =  User::select('panellist_id')->where('uuid',$uuid)->first();
        $userData =  \DB::table('users')->select('panellist_id')->where('uuid',$uuid)->first();
        if(!empty($userData)){
           return $userData->panellist_id;
        }else{
           return null;
        }
    }

    /**
     * @var array $hidden
     */
    protected $hidden = ['password', 'remember_token','google2fa_secret'];

    /**
     * @var array $dates
     */
   /* protected $dates = ['last_login_at', 'deleted_at'];*/
    protected $dates = ['deleted_at', 'dob', 'last_login_at'];
    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array $appends
     */
    protected $appends = ['full_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'active' => 'boolean',
        'confirmed' => 'boolean',
    ];

    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = encrypt($value);
    }
    public function getGoogle2faSecretAttribute($value)
    {
        if($this->two_fact_auth==1){
            return decrypt($value);
        }else{
            return true;
        }
    }

    public static function laratablesCustomConfirmedLabel($user)
    {
        return $user->confirmed_label;
    }
    public static function laratablesCustomRoleLabel($user)
    {
        return $user->roles_label;
    }
    public static function laratablesCustomPermissionLabel($user)
    {
        return $user->permissions_label;
    }
    public static function laratablesCustomSocialButton($user)
    {
        return $user->social_buttons;
    }
    public static function laratablesCustomAction($user)
    {
        return $user->action_buttons;
    }
    public static function laratablesCustomUpdated($user)
    {
        return $user->updated_at->diffForHumans();
    }
    public static function laratablesCustomAction2($user)
    {
        return $user->action_buttons_2;
    }
    public static function laratablesCustomSocialButton2($user)
    {
        return $user->social_buttons_2;
    }

    public function requestRedeems()
    {
        return $this->hasMany(RequestRedeem::class, 'user_uuid', 'uuid');
    }

    public function panelistAddress()
    {
        return $this->hasOne(PanellistAddress::class,'user_id','id');
    }
    public function storedImage()
    {
        return $this->hasOne(StoredImage::class, 'entity_id')
                    ->where('storage_key', 'profile_picture');
    }
 
    // Accessor for main image path
    public function getMainImagePathAttribute()
    {
        return $this->storedImage ? $this->storedImage->main_image_path : null;
    }
 
    // Accessor for thumbnail image path
    public function getThumbnailImagePathAttribute()
    {
        return $this->storedImage ? $this->storedImage->thumbnail_image_path : null;
    }
}
