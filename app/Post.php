<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'title', 'content', 'slug', 'user_id', 'topic_id', 'date_public', 'lead', 'meta_desc', 'thumbnail', 'number', 'marked'
    ];
    protected $dates = [
        'date_public'
    ];

    public function topic(){
        return $this->belongsTo('\App\Topic');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }


}
