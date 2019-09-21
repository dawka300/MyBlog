<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['topic'];

    public function posts(){
        return $this->hasMany('\App\Post');
    }
}
