<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 20/01/2018
 * Time: 13:05
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class UserPreferences extends Model {
    protected $table = 'users_preferences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'conta_principal',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}