<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;
    protected $table = 'quotes';
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function quoteItems()
    {
        return $this->hasMany('App\QuoteItem', 'quote_id', 'id');
    }

    public function bids()
    {
        return $this->hasMany('App\Bid', 'quote_id', 'id');
    }
}
