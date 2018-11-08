<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{

    protected $table = 'upload'; 
    protected $fillable = [
         'user_id','filename', 'origin_file',
    ];

}
