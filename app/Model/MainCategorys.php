<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MainCategorys extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'mac_id';
    const CREATED_AT = 'mac_createat';
    const UPDATED_AT = 'mac_updateat';
    protected $table = 'tbl_main_categorys';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
