<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;

    public function getClientMedications(){
        return $this->hasMany(Medication::class, 'client_id')->orderBy('id', 'DESC');
    }

    public function getClientGroup(){
        return $this->belongsTo(ClientGroup::class, 'client_group_id');
    }

    public function getAssignedTo(){
        return $this->belongsTo(User::class, 'assigned_to');
    }

     public function getAddedBy(){
        return $this->belongsTo(User::class, 'added_by');
    }

    public function getClientAppointments(){
        return $this->hasMany(CalendarInvitee::class, 'invitee_id')->orderBy('id', 'DESC');
    }


    public function getClientLogs(){
        return $this->hasMany(ActivityLog::class, 'client_id')->orderBy('id', 'DESC');
    }


    public function addClient(Request $request):Client{
        $client = new Client();
        $client->added_by = Auth::user()->id;
        $client->org_id = Auth::user()->org_id;
        $client->client_group_id = $request->clientGroup;
        $client->first_name = $request->firstName;
        $client->last_name = $request->lastName ?? '';
        $client->email = $request->email ?? 'info@placeholder.com';
        $client->mobile_no = $request->mobileNo;
        $client->slug = Str::slug($request->firstName).'-'.Str::random(8);
        $client->created_at = $request->date ?? now();
        $client->save();
        return $client;
    }
    public function editClient(Request $request):Client{
        $client =  Client::find($request->clientId);
        $client->added_by = Auth::user()->id;
        $client->org_id = Auth::user()->org_id;
        $client->client_group_id = $request->clientGroup;
        $client->first_name = $request->firstName;
        $client->last_name = $request->lastName;
        $client->email = $request->email;
        $client->mobile_no = $request->mobileNo;
        //$client->slug = Str::slug($request->firstName).'-'.Str::random(8);
        $client->birth_date = $request->birthDate ?? null;
        $client->current_weight = $request->currentWeight ?? null ;
        $client->quick_note = $request->quickNote ?? null ;
        $client->address = $request->address ?? null;
        $client->save();
        return $client;
    }

    public function getClientBySlug($slug){
        return Client::where('slug', $slug)->first();
    }

    public function getClientById($id){
        return Client::find( $id);
    }

    public function getClients(){
        return Client::orderBy('created_at', 'DESC')->get();
    }
    public function getAllMyClients($authorId, $orgId){
        return Client::where('added_by', $authorId)->where('org_id', $orgId)->orderBy('first_name', 'ASC')->get();
    }
    public function getAllMyClientsDateRange($authorId, $orgId, $from, $to){
        return Client::where('added_by', $authorId)->where('org_id', $orgId)->whereBetween('created_at', [$from, $to])->orderBy('first_name', 'ASC')->get();
    }
    public function getAllOrgClients( $orgId){
        return Client::where('org_id', $orgId)->orderBy('first_name', 'ASC')->get();
    }
    public function getClientsByStatus($status){
        return Client::where('status', $status)->orderBy('first_name', 'ASC')->get();
    }

    public function assignClient($assignTo, $clientId){
        $client = Client::find($clientId);
        $client->assigned_to = $assignTo;
        $client->save();
    }

    public function archiveOrUnarchiveClient($clientId, $status){
        $client = Client::find($clientId);
        $client->status = $status;
        $client->save();
    }
    public function uploadProfilePicture($avatarHandler, $clientId){
        $filename = $avatarHandler->store('avatars', 'public');
        $avatar = Client::find($clientId);
        if($avatar->avatar != 'avatars/avatar.png'){
            $this->deleteFile($avatar->avatar); //delete file first
        }
        $avatar->avatar = $filename;
        $avatar->save();
    }
    public function deleteFile($file){
        if(\File::exists(public_path('storage/'.$file))){
            \File::delete(public_path('storage/'.$file));
        }
    }
}
