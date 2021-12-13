<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mobiles extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'mob_id';
    const CREATED_AT = 'mob_createat';
    const UPDATED_AT = 'mob_updateat';
    protected $table = 'tbl_mobiles';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
