<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class Address extends Model
{
   protected $connection = 'mongodb';
   protected $collection = 'tbl_address';
   protected $fillable = [
        'label', 'street_address',
    ];
}
