<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ModuleManager extends Model
{
    use HasFactory;

    public function getPermissions(){
        return $this->hasMany(Permission::class, 'module_id');
    }

    public function addModule($data){
        $module = new ModuleManager();
        $module->module_name = $data['moduleName'];
        $module->area = $data['area'];
        $module->slug = Str::slug($data['moduleName']).'-'.Str::random(8);
        $module->save();
    }

     public function editModule($data){
        $module =  ModuleManager::find($data['moduleId']);
        $module->module_name = $data['moduleName'];
        $module->area = $data['area'];
         $module->slug = Str::slug($data['moduleName']).'-'.Str::random(8);
        $module->save();
    }

    public function getModules(){
        return ModuleManager::orderBy('module_name', 'ASC')->get();
    }

    public function getModulesByArea($area){
        return ModuleManager::where('area', $area)->orderBy('module_name', 'ASC')->get();
    }


}
