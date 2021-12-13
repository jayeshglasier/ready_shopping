<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'pri_id';
    const CREATED_AT = 'pri_createat';
    const UPDATED_AT = 'pri_updateat';
    protected $table = 'tbl_product_images';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
