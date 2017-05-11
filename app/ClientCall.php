<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientCall extends Model
{
   	 protected $guarded = ['id']; 
     protected $primaryKey = 'id';
     protected $table = 'clientCalls';
}
