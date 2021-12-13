<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Villages extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'vil_id';
    const CREATED_AT = 'vil_createat';
    const UPDATED_AT = 'vil_updateat';
    protected $table = 'tbl_villages';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
