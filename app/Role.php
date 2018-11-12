<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

use Zizaco\Entrust\EntrustRole;
use App\User;
class Role extends EntrustRole
{
	protected $table = 'roles';
    
    protected $fillable = ['name', 'display_name','description'];
 
	public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
	
}