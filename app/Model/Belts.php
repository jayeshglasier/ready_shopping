<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Belts extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'blt_id';
    const CREATED_AT = 'blt_createat';
    const UPDATED_AT = 'blt_updateat';
    protected $table = 'tbl_belts';

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
