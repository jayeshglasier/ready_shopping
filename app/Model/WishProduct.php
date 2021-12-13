<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WishProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'wis_id';
    const CREATED_AT = 'wis_createat';
    const UPDATED_AT = 'wis_updateat';
    protected $table = 'tbl_wish_product';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
