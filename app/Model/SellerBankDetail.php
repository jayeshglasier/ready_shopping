<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SellerBankDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'sbd_id';
    const CREATED_AT = 'sbd_createat';
    const UPDATED_AT = 'sbd_updateat';
    protected $table = 'tbl_seller_bank_details';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}