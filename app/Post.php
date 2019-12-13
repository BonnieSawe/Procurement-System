<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    use SoftDeletes;
    protected $table = 'posts';
    
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\Author');
    }

    public function postTags()
    {
        return $this->hasMany('App\PostTag', 'post_id', 'id');
    }
}
