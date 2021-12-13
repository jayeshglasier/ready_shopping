<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'sip_id';
    const CREATED_AT = 'sip_createat';
    const UPDATED_AT = 'sip_updateat';
    protected $table = 'tbl_shiping_address';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
