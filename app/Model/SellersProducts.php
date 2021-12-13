<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SellersProducts extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'sep_id';
    const CREATED_AT = 'sep_createat';
    const UPDATED_AT = 'sep_updateat';
    protected $table = 'tbl_sellers_products';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
