<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 14/01/2018
 * Time: 11:36
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Transacao extends Model {

    protected $table = 'transacoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'trans_id', 'tipo', 'valor',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

}