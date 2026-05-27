<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Session;

class Role extends Model
{
    use HasFactory;
	
	protected $table='roles';
	
	protected $fillable = ['id','role'];
	 
    protected $hidden = [
        'created_at',
		'updated_at',
    ];

}
