<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;

    public static function subDomain() :Organization {
        return Organization::where('sub_domain', strtolower(str_replace('.'. env('APP_URL'), '', request()->getHost())))->firstOrFail();
    }

    public function getState(){
        return $this->belongsTo(State::class, 'state');
    }

    public function getOrgServices(){
        return $this->hasMany(Service::class, 'org_id')->orderBy('title', 'ASC');
    }


    public function registerOrganziationDuringRegistration($organizationName, $phone, $email, ){

        $active_key = "key_".substr(sha1(time()),23,40);
        $org = new Organization();
        $org->organization_name = $organizationName;
        $org->phone_no = $phone;
        $org->active_sub_key = $active_key;
        $org->slug = Str::slug($organizationName).'-'.substr(sha1(time()),33,40);
        $org->email = $email;
        $org->start_date = now();
        $org->end_date = Carbon::now()->addDays(180); //6 months FREE trial
        $org->plan_id = 1; //free
        $org->sub_domain = substr(strtolower(str_replace(" ","",$organizationName)),0,15).'.'.env('APP_URL');
        $org->save();
        return $org;
    }

    public function addOrganization($data){
        $org = new Organization();
        $org->organization_name = $data['organizationName'];
        $org->organization_code = $data['organizationCode'];
        $org->tax_id_type = $data['taxIDType'] ?? 1;
        $org->tax_id_no = $data['organizationTaxIDNumber'] ?? 1;
        $org->phone_no = $data['organizationPhoneNumber'];
        $org->address = $data['addressLine'];
        $org->city = $data['city'];
        $org->state = $data['state'];
        $org->zip_code = $data['zipCode'] ?? null;
        $org->country = $data['country'];
        $org->email = $data['organizationEmail'];
        $org->save();
    }
    public function updateOrganizationSettings(Request $request){
        $org =  Organization::find($request->orgId);
        $org->organization_name = $request->organizationName ?? null;
        $org->organization_code = $request->organizationCod ?? null;
        //$org->tax_id_type = $request->taxIDType ?? null;
        //$org->tax_id_no = $request->organizationTaxIDNumber ?? null;
        $org->phone_no = $request->organizationPhoneNumber ?? null;
        $org->address = $request->addressLine ?? null;
        $org->city = $request->city ?? null;
        $org->state = $request->state ?? null;
        $org->zip_code = $request->zipCode ?? null;
        $org->country = $request->country ?? null;
        $org->facebook_handle = $request->facebookPage ?? null;
        $org->twitter_handle = $request->twitterAccount ?? null;
        $org->instagram_handle = $request->instagram ?? null;
        $org->youtube_handle = $request->youtubeChannel ?? null;
        $org->theme_choice = $request->themeChoice ?? 1;
        $org->ui_color = $request->uiColor ?? '#2A3041';
        $org->btn_text_color = $request->btnTextColor ?? '#FFFFFF';
        $org->publish_site = isset($request->publishSite) ? 1 : 0;
        $org->save();
    }
 public function editOrganization($organizationId, $data){
        $org =  Organization::where('id', $organizationId)->first();
        $org->organization_name = $data['organizationName'];
        $org->organization_code = $data['organizationCode'];
        $org->tax_id_type = $data['taxIDType'] ?? 1;
        $org->tax_id_no = $data['organizationTaxIDNumber'] ?? 1;
        $org->phone_no = $data['organizationPhoneNumber'] ;
        $org->address = $data['addressLine'];
        $org->city = $data['city'];
        $org->state = $data['state'];
        $org->zip_code = $data['zipCode'];
        $org->country = $data['country'];
        $org->email = $data['organizationEmail'];
        $org->save();
    }

    public function uploadLogo($logoHandler){
        $filename = $logoHandler->store('logos', 'public');
        $log = Organization::find(Auth::user()->org_id);
        if($log->logo != 'logos/logo.png'){
            $this->deleteFile($log->logo); //delete file first
        }
        $log->logo = $filename;
        $log->save();
    }
    public function uploadFavicon($faviconHandler){
        $filename = $faviconHandler->store('logos', 'public');
        $log = Organization::find(Auth::user()->org_id);
        if($log->favicon != 'logos/favicon.png'){
            $this->deleteFile($log->favicon); //delete file first
        }
        $log->favicon = $filename;
        $log->save();
    }

    public function deleteFile($file){
        if(\File::exists(public_path('storage/'.$file))){
            \File::delete(public_path('storage/'.$file));
        }
    }

    public function getUserOrganization($orgId){
        return Organization::find($orgId);
    }

    public function getSubDomain(Request $request){
        return strtolower(str_replace('.'. env('APP_URL'), '', request()->getHost()));
    }

    public function getOrganizationBySubdomain($website){
        return Organization::where('sub_domain', $website)->first();
    }
}
