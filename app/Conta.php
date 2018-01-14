<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 14/01/2018
 * Time: 14:12
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model {
    protected $table = 'contas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'conta_id', 'nome',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}