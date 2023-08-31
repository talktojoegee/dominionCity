<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Permission extends Model
{
    use HasFactory;

    public function getPermissionModule(){
        return $this->belongsTo(ModuleManager::class, 'module_id');
    }

    public function addPermission(Request $request){
        $permission = new Permission();
        $permission->name = $request->permissionName ?? '' ;
        $permission->guard_name = 'web';
        $permission->module_id = $request->module ?? 1;
        $permission->save();
    }
    public function editPermission(Request $request){
        $permission =  Permission::find($request->permissionId);
        $permission->name = $request->permissionName ?? '';
        $permission->guard_name = 'web';
        $permission->module_id = $request->module ?? 1;
        $permission->save();
    }

    public function getPermissions(){
        return Permission::all();
    }

    public function getPermissionsByIds($ids){
        return Permission::whereIn('id', $ids)->pluck('name')->toArray();
    }
}
