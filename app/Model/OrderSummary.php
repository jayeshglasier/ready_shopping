<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderSummary extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'ors_id';
    const CREATED_AT = 'ors_createat';
    const UPDATED_AT = 'ors_updateat';
    protected $table = 'tbl_orders_summary';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}