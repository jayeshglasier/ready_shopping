<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChooseType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'coo_id';
    const CREATED_AT = 'coo_createat';
    const UPDATED_AT = 'coo_updateat';
    protected $table = 'tbl_choose_type';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
