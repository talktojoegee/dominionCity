<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Role extends Model
{
    use HasFactory;


    public function getPermissions(){
        return $this->hasMany(RoleHasPermission::class, 'role_id');
    }


    public function getRoles(){
        return Role::all();
    }

    public function addRole(Request $request){
        $role = new Role();
        $role->name = $request->name ?? '';
        $role->guard_name = 'web';
        $role->save();
        return $role;
    }


    public function getRoleById($roleId){
        return Role::find($roleId);
    }


    public function getPermission($permissionId){
        return RoleHasPermission::where('permission_id', $permissionId)->first();
    }

    public function getPermissionIdsByRoleId($roleId){
        return RoleHasPermission::where('role_id', $roleId)->pluck('permission_id')->toArray();
    }


}
