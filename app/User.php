<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
     protected $guarded = ['id']; 
     protected $primaryKey = 'id';
     protected $table = 'users';
}
