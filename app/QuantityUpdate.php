<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class QuantityUpdate extends Authenticatable
{
    use Notifiable;
	protected $connection = 'mongodb';
    protected $collection = 'tbl_purchase_order_qty_update';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     
     public function QuantityUpdate(){
        return $this->belongsTo('tbl_purchase_order_qty_update_intake_form');
    }
    
}
