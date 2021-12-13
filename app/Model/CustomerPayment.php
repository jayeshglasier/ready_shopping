<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'pay_id';
    const CREATED_AT = 'pay_createat';
    const UPDATED_AT = 'pay_updateat';
    protected $table = 'tbl_payment';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
