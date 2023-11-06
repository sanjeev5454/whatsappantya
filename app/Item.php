<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class Item extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'tbl_items';
   protected $fillable = [
        'user_id', 'item_name', 'item_sku','description','unit','quantity','price','vendor_id','gst','status',
    ];
	
}
