<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Watches extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'wat_id';
    const CREATED_AT = 'wat_createat';
    const UPDATED_AT = 'wat_updateat';
    protected $table = 'tbl_watches';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
