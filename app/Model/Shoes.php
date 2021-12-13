<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shoes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'sho_id';
    const CREATED_AT = 'sho_createat';
    const UPDATED_AT = 'sho_updateat';
    protected $table = 'tbl_shoes';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
