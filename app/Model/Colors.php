<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'col_id';
    const CREATED_AT = 'col_createat';
    const UPDATED_AT = 'col_updateat';
    protected $table = 'tbl_colors';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
