<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;


class Vendor extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'tbl_vendor';
  
   protected $fillable = [
        'vendor_name', 'address', 'contact_person','email','whatsapp_number','mobile_number','status',
    ];
}
