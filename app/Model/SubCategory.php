<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'sub_id';
    const CREATED_AT = 'sub_createat';
    const UPDATED_AT = 'sub_updateat';
    protected $table = 'tbl_sub_categorys';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}