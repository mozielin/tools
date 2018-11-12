<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;
use App\Role;
class Permission extends EntrustPermission
{
	protected $table = 'permissions';

    protected $fillable = ['name', 'display_name','description'];
 
	public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
	
}