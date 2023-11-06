<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class PurchaseOrder extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'tbl_purchase_order';
   
   protected $fillable = [
        'vendor_name', 'address', 'contact_person','email','whatsapp_number','mobile_number','status',
    ];
}
