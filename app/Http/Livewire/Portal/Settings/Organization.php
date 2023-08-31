<?php

namespace App\Http\Livewire\Portal\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use \App\Models\Organization as Org;
use Livewire\WithFileUploads;

class Organization extends Component
{
    use WithFileUploads;
    public $organizationName, $organizationCode, $taxIDType, $organizationTaxIDNumber, $organizationPhoneNumber;
    public $addressLine, $city, $state, $zipCode, $country, $organizationEmail;
    public $orgDetails;
    public $logo, $favicon;

    public function __construct()
    {
        $this->organization = new Org();
    }

    public function saveOrganizationSettings(){

        $validatedData = $this->validate([
           'organizationName'=>'required',
           'organizationCode'=>'required|unique:organizations,organization_code,'.Auth::user()->org_id,
           //'taxIDType'=>'required',
           //'organizationTaxIDNumber'=>'required',
           'organizationPhoneNumber'=>'required',
           'organizationEmail'=>'required|email',
           'addressLine'=>'required',
           'city'=>'required',
           'state'=>'required',
           'country'=>'required',
           //'zipCode'=>'required',
        ],[
            "organizationName.required"=>"Enter church name",
            "organizationCode.required"=>"Enter CAC RC. Number",
            "organizationCode.unique"=>"This CAC RC. Number is already taken.",
            "organizationEmail.required"=>"Enter church email address",
            "organizationEmail.email"=>"Enter a valid email address",
            "organizationPhoneNumber.required"=>"Enter  phone number",
            "addressLine.required"=>"Where's the church located?",
            "city.required"=>"In which city is the church situated?",
            "country.required"=>"In which country is the church situated?",
            //"zipCode.required"=>"Enter your postal code",
            "state.required"=>"Choose state",
        ]);
        $org = $this->organization->getUserOrganization(Auth::user()->org_id);
        if(empty($org)){
            $this->organization->addOrganization($validatedData);
            session()->flash("success", "Your organization settings were published!");
            $this->reset();
        }else{
            $this->organization->editOrganization(Auth::user()->org_id, $validatedData);
            session()->flash("success", "Your changes were saved!");
            $this->reset();
        }
    }

    public function saveLogo(){
        $this->validate([
            'logo' => 'required|image|max:1024|mimes:jpg,png,jpeg',
        ],[
            "logo.required"=>"Choose a logo to upload",
            "logo.image"=>"Choose an image file",
            "logo.mimes"=>"Unsupported file format chosen",
        ]);
       $this->organization->uploadLogo($this->logo);
        $this->reset();
        session()->flash("success", "Your organization logo was uploaded.");
    }
    public function saveFavicon(){
        $this->validate([
            'favicon' => 'required|image|max:1024|mimes:jpg,png,jpeg',
        ],[
            "favicon.required"=>"Choose a favicon to upload",
            "favicon.image"=>"Choose an image file",
            "favicon.mimes"=>"Unsupported file format chosen",
        ]);
       $this->organization->uploadFavicon($this->favicon);
        $this->reset();
        session()->flash("success", "Your organization favicon was uploaded.");
    }

    public function render()
    {   $details = $this->organization->getUserOrganization(Auth::user()->org_id);
        $this->fill([
            'organizationName'=>$details->organization_name ?? '',
            'organizationCode'=>$details->organization_code ?? '',
            'taxIDType'=>$details->tax_id_type ?? '',
            'organizationTaxIDNumber'=>$details->tax_id_no ?? '',
            'organizationPhoneNumber'=>$details->phone_no ?? '',
            'organizationEmail'=>$details->email ?? '',
            'addressLine'=>$details->address ?? '',
            'city'=>$details->city ?? '', 'state'=>$details->state ?? '',
            'zipCode'=>$details->zip_code ?? '', 'country'=>$details->country ?? ''
        ]);
        return view('livewire.portal.settings.organization')
            ->extends('layouts.master-layout')
            ->section('main-content');
    }
}
