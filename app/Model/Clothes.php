<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Clothes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'clt_id';
    const CREATED_AT = 'clt_createat';
    const UPDATED_AT = 'clt_updateat';
    protected $table = 'tbl_clothes';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
