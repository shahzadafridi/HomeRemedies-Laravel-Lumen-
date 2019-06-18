<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
 
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'picture',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

 
}
