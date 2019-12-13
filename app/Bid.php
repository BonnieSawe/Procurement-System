<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bid extends Model
{
    use SoftDeletes;
    protected $table = 'bids';
    protected $dates = ['deleted_at'];

    public function supplier()
    {
        return $this->belongsTo('App\User', 'supplier_id');
    }

    public function quote()
    {
        return $this->belongsTo('App\Quote', 'quote_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'comment_id', 'id');
    }
}
