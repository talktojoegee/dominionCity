<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserCountry(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function getUserState(){
        return $this->belongsTo(State::class, 'state_id');
    }

    public function getUserMaritalStatus(){
        return $this->belongsTo(MaritalStatus::class, 'marital_status');
    }
    public function getUserRole(){
        return $this->belongsTo(Role::class, 'role');
    }


    public function getUserChurchBranch(){
        return $this->belongsTo(ChurchBranch::class, 'branch');
    }
    public function getUserAccount(){
        return $this->hasMany(BulkSmsAccount::class, 'user_id')->orderBy('id', 'DESC');
    }
    public function getOrgServices(){
            return $this->hasMany(Service::class, 'org_id')->orderBy('title', 'ASC');
    }

    public function getUserAppointments(){
        return $this->hasMany(Calendar::class, 'created_by')->orderBy('id', 'DESC');
    }

    public function getUserNotifications(){
        return $this->hasMany(Notification::class, 'user_id')->whereNull('read_at')->orderBy('id', 'DESC');
    }

    public function getUserOrganization(){
        return $this->belongsTo(Organization::class, 'org_id', 'id');
    }


    public function getUserHomepageSettings(){
        return $this->belongsTo(Homepage::class, 'org_id');
    }

    public function registerUser(Request $request, $orgId){
        //$password = Str::random(8);
        $user = new User();
        $user->first_name = $request->firstName;
        $user->org_id = $orgId;
        $user->last_name = $request->lastName;
        $user->cellphone_no = $request->mobileNo;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->is_admin = 2; //$request->userType;
        $user->uuid = Str::uuid();
        $user->api_token = Str::random(60);
        $user->slug = Str::slug($request->firstName).'-'.Str::random(8);
        $user->save();
        return $user;
    }
    public function createUser(Request $request){
        $password = Str::random(8);
        $user = new User();
        $user->title = $request->title ?? null;
        $user->first_name = $request->firstName;
        $user->org_id = Auth::user()->org_id;
        $user->last_name = $request->lastName;
        $user->other_names = $request->otherNames;
        $user->cellphone_no = $request->mobileNo;
        $user->marital_status = $request->maritalStatus;
        $user->role = $request->role ?? null;
        $user->pastor = isset($request->pastor) ? 1 : 0;
        $user->gender = isset($request->gender) ? 1 : 0;
        $user->email = $request->email;
        $user->occupation = $request->occupation ?? null;
        $user->branch = $request->branch ?? null;
        $user->country_id = $request->nationality ?? null;
        $user->birth_date = $request->dob ?? null;
        $user->birth_year = date('Y', strtotime($request->dob)) ?? null;
        $user->birth_month = date('m', strtotime($request->dob)) ?? null;
        $user->birth_day = date('d', strtotime($request->dob)) ?? null;
        $user->password = bcrypt($password);
        $user->is_admin = $request->userType;
        $user->address_1 = $request->presentAddress ?? null;
        $user->uuid = Str::uuid();
        $user->api_token = Str::random(60);
        $user->slug = Str::slug($request->firstName).'-'.Str::random(8);
        $user->save();
        return $user;
    }

    public function archiveUser($userId){
        $user = User::find($userId);
        $user->status = 3; //supposed to be deleted | we're archiving instead
        $user->save();
    }

    public function updateUserAccount(Request $request):User{
        $user = User::find(Auth::user()->id);
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->cellphone_no = $request->cellphoneNumber;
        $user->state_id = $request->state;
        $user->country_id = $request->country;
        $user->save();
        return $user;
    }
    public function getUserByEmail($email){
        return User::where('email', $email)->first();
    }

    public function getUserNotificationSettings($userId){
        return UserNotificationSetting::where('user_id', $userId)->first();
    }
    public function getUserById($id){
        return User::find( $id);
    }

    public function uploadProfilePicture($avatarHandler){
        $filename = $avatarHandler->store('avatars', 'public');
        $avatar = User::find(Auth::user()->id);
        if($avatar->image != 'avatars/avatar.png'){
            $this->deleteFile($avatar->image); //delete file first
        }
        $avatar->image = $filename;
        $avatar->save();
    }

    public function deleteFile($file){
        if(\File::exists(public_path('storage/'.$file))){
            \File::delete(public_path('storage/'.$file));
        }
    }

    public function getAllUsers(){
        return User::orderBy('first_name', 'ASC')->get();
    }
    public function getAllOrgUsersByIsAdmin($type){
        return User::where('is_admin', $type)->orderBy('first_name', 'ASC')->get();
    }

    public function getAllOrgUsersByType($type){
        return User::where('is_admin', $type)->where('org_id', Auth::user()->org_id)->orderBy('first_name', 'ASC')->get();
    }

    public function getAllOrganizationUsers(){
        return User::where('org_id', Auth::user()->org_id)->where('status', '!=', 3)->orderBy('first_name', 'ASC')->get();
    }

    public function getUserBySlug($slug){
        return User::where('slug', $slug)->first();
    }

    public function getOtherUsersSameBranch($branch){
        return User::where('branch', $branch)->take(5)->get();
    }

    public function getAllBranchUsers($branchId){
        return User::where('branch', $branchId)->orderBy('first_name', 'ASC')->get();
    }


/*
    public function getUserAccount(){ //git test
        return $this->hasMany(BulkSmsAccount::class, 'user_id')->orderBy('id', 'DESC');
    }*/

    public function getUserBulkSMSReport(){
        return $this->hasMany(BulkMessage::class, 'user_id')->orderBy('id', 'DESC');
    }

    public function getUserPhoneGroups(){
        return $this->hasMany(PhoneGroup::class, 'user_id');
    }

    public function getUserSenderIds(){
        return $this->hasMany(SenderId::class, 'user_id');
    }

/*
    public function createUser(Request $request){
        $user = new User();
        $user->first_name = $request->firstName;
        $user->mobile_no = $request->phoneNumber;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->uuid = Str::uuid();
        $user->api_token = Str::random(60);
        $user->save();
        return $user;
    }*/


    public function apiTokenGenerator(){
        $user = User::find(Auth::user()->id);
        $user->api_token = Str::random(60);
        $user->save();
    }

    public function getUserByUuid($uuid){
        return User::where('uuid', $uuid)->first();
    }
   /* public function getUserById($id){
        return User::find( $id);
    }*/

    public function updateUser(Request $request, $mobile){
        $user = User::find($request->id);
        $user->first_name = $request->firstName;
        $user->mobile_no = $request->phoneNumber;
        //$user->email = $request->email;
        //$user->password = bcrypt($request->password);
        $user->uuid = Str::uuid();
        $user->save();
        return $user;
    }
   /* public function getUserByEmail($email){
        return User::where('email', $email)->first();
    }*/

    public function getToken($token){
        return User::select('api_token')->where('api_token', $token)->first();
    }

/*
    public function apiTokenGenerator(){
        $user = User::find(Auth::user()->id);
        $user->api_token = Str::random(60);
        $user->save();
    }




    public function updateUser(Request $request, $mobile){
        $user = User::find($request->id);
        $user->first_name = $request->firstName;
        $user->mobile_no = $request->phoneNumber;
        //$user->email = $request->email;
        //$user->password = bcrypt($request->password);
        $user->uuid = Str::uuid();
        $user->save();
        return $user;
    }


    public function getToken($token){
        return User::select('api_token')->where('api_token', $token)->first();
    }*/

}
