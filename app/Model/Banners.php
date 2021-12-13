<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'ban_id';
    const CREATED_AT = 'ban_createat';
    const UPDATED_AT = 'ban_updateat';
    protected $table = 'tbl_banners';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
