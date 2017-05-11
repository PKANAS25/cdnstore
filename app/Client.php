<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
     protected $guarded = ['id']; 
     protected $primaryKey = 'id';
     protected $table = 'clients';

}
