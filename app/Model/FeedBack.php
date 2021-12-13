<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'fed_id';
    const CREATED_AT = 'fed_createat';
    const UPDATED_AT = 'fed_updateat';
    protected $table = 'tbl_feed_back';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
