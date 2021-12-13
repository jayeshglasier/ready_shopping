<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'wal_id';
    const CREATED_AT = 'wal_createat';
    const UPDATED_AT = 'wal_updateat';
    protected $table = 'tbl_wallets';
    
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = [];
}
