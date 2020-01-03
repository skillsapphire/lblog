<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Everything thats needed comes from Model class so you dont have to do much here,
    // if you want to do something refer documentation
    protected $table = "posts";
    public $primaryKey = "id";
    public $timestamps = true;

    // creating relationship btwn user and posts
    public function user(){
        // this post belongs to the user
        return $this->belongsTo('App\User');
    }
}
