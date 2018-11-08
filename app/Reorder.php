<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reorder extends Model
{
	protected $table = 'reorder'; 
    protected $fillable = [
         'listname','jsondata','user_id'
    ];
}
