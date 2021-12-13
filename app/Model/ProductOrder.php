<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'ord_id';
    const CREATED_AT = 'ord_createat';
    const UPDATED_AT = 'ord_updateat';
    protected $table = 'tbl_orders';

    public function productlist()
    {
        return $this->hasmany('App\Model\OrderSummary','ors_order_id','ord_order_id');
    }
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
