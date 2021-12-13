<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'crt_id';
    const CREATED_AT = 'crt_createat';
    const UPDATED_AT = 'crt_updateat';
    protected $table = 'tbl_cart';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
