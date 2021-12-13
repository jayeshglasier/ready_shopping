<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'pod_id';
    const CREATED_AT = 'pod_createat';
    const UPDATED_AT = 'pod_updateat';
    protected $table = 'tbl_products';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
