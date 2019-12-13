<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteItem extends Model
{
    use SoftDeletes;
    protected $table = 'quote_items';
    protected $dates = ['deleted_at'];

    public function quote()
    {
        return $this->belongsTo('App\Quote', 'quote_id');
    }
}
