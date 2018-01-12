<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 12/01/2018
 * Time: 18:34
 */

namespace App;
use Illuminate\Database\Eloquent\Model;


class Investment extends Model {

    protected $table = 'investimentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'investimento_id', 'tipo_investimento', 'valor', 'lucro',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

}