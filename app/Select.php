<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Select extends Model

{

	protected $table = 'select'; 
    protected $fillable = [
         'header','note'
    ];
}
