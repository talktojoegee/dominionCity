<?php

namespace App\Http\Livewire\Portal\Settings;

use Livewire\Component;
use App\Models\ModuleManager as mManager;

class ModuleManager extends Component
{
    public $moduleName, $area;
    public $modules;

    public function __construct($id = null)
    {
        $this->modulemanager = new mManager();
    }

    public function mount(){
        $this->area = 0;
    }

    public function addNewModule(){
        $validatedData = $this->validate([
           "moduleName"=>"required",
           "area"=>"required",
        ],[
            "moduleName.required"=>"Enter module name",
            "area.required"=>"Choose module area"
        ]);
        $this->modulemanager->addModule($validatedData);
        $this->reset();
        session()->flash('success', 'New module published!');
    }
    public function render()
    {
        $this->modules = $this->modulemanager->getModules();
        $this->area = 0;
        return view('livewire.portal.settings.module-manager')
            ->extends('layouts.master-layout')
            ->section('main-content');
    }


}
