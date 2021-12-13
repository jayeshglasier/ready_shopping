<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'cat_id';
    const CREATED_AT = 'cat_createat';
    const UPDATED_AT = 'cat_updateat';
    protected $table = 'tbl_categorys';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
