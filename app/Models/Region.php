<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Region
 * @package App\Models
 * @version January 26, 2024, 7:15 pm UTC
 *
 * @property string $name
 * @property string $name_en
 */
class Region extends Model
{
        use SoftDeletes;

        use HasFactory;

    public $table = 'regions';
    
    
    protected $dates = ['deleted_at'];

    
    
    public $fillable = [
        'name',
        'name_en'
    ];

    const _PROFILE = 'avatar';
    const _PASSWORDS = false;
    const _FILES = true;
    const _FILE_PATH = "storage/regions/" . self::_PROFILE . '/';

    public static $modelFiles = [
        'avatar' =>  self::_FILE_PATH
    ];

    public function getAvatarPathAttribute()
    {
        return "storage/$this->table/" . self::_PROFILE . '/';
    }

    public function getAvatarUrlAttribute()
    {
        /*
        $avatar = self::_PROFILE;
        return asset($this->avatar_path . $$avatar);
        */
        $avatar = $this->avatar;
        return asset($this->avatar_path . $avatar);
    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'name_en' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'name_en' => 'required'
    ];

    



}
