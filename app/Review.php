<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'remedie_id',
        'rating',
        'description',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

 
}
