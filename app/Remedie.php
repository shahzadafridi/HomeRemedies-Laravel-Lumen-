<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Remedie extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'user_id',
        'user_name', 
        'title',
        'type',
        'category',
        'description',
        'picture',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function reviews()
    // {
    //     return $this->hasMany('App\Review', 'user_id');
    // }

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
