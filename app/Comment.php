<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $table = 'comments';
    protected $dates = ['deleted_at'];

    public function bid()
    {
        return $this->belongsTo('App\Bid', 'comment_id');
    }
    
}
