<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes
use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\Traits\Encryptable;
use App\Models\Auth\User;

class StoredImage extends Model
{
    use SoftDeletes,Encryptable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stored_images'; // You can name your table whatever you like

    protected $encryptable = [
        'main_image_path','thumbnail_image_path'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'entity_id',
        'storage_key',
        'image_profile',
        'source',
        'disk',
        'reference_id',
        'original_filename',
        'main_image_path',
        'thumbnail_image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Add any casts if needed, e.g., for JSON fields if you add them later
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'entity_id');
    }
}
