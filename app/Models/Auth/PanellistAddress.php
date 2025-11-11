<?php
namespace App\Models\Auth;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\User;
class PanellistAddress extends Model
{
    // use HasFactory;

    protected $table = 'panellist_address';

    protected $fillable = [
        'user_id',
        'city',
        'state',
        'region',
    ];

    public function panelist()
    {
        return $this->belongsTo(User::class,'id','user_id');
    }
}