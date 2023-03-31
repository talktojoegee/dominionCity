<?php

namespace App\Http\Controllers\portal;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\ClientGroup;
use App\Models\FileModel;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->client = new Client();
        $this->clientgroup = new ClientGroup();
        $this->filemodel = new FileModel();
        $this->users = new User();
        //$this->notification = new Notification();
    }

    public function showClients(){
        return view('clients.index', [
            'clients'=>$this->client->getClients(),
            'clientGroups'=>$this->clientgroup->getClientGroups()
        ]);
    }

    public function addClient(Request $request){
        $this->validate($request,[
           'firstName'=>'required',
           'lastName'=>'required',
           'email'=>'required|email',
           'mobileNo'=>'required',
           'clientGroup'=>'required',
        ],[
            "firstName.required"=>"Enter client first name",
            "lastName.required"=>"Enter client last name",
            "email.required"=>"Enter client email address",
            "email.email"=>"Enter a valid email address",
            "mobileNo.required"=>"Enter client mobile phone number",
            "clientGroup.required"=>"Assign client to a group",
        ]);

        try{
            $client = $this->client->addClient($request);
            //setNewNotification($subject, $body, $route_name, $route_param, $route_type, $user_id, $orgId)
            Notification::setNewNotification('New client registration', 'A new client was registered to the system',
            'view-client-profile', $client->slug, 1, Auth::user()->id, Auth::user()->org_id);
            session()->flash("success", "Your client was added to the system!");
            return back();
        }catch (\Exception $exception){
            session()->flash("error", "Whoops! Something went wrong.");
            return back();
        }

    }


    public function editClientProfile(Request $request){
        $this->validate($request,[
           'firstName'=>'required',
           'lastName'=>'required',
           'email'=>'required|email',
           'mobileNo'=>'required',
           'clientGroup'=>'required',
           'clientId'=>'required',
        ],[
            "firstName.required"=>"Enter client first name",
            "lastName.required"=>"Enter client last name",
            "email.required"=>"Enter client email address",
            "email.email"=>"Enter a valid email address",
            "mobileNo.required"=>"Enter client mobile phone number",
            "clientGroup.required"=>"Assign client to a group",
        ]);
        $this->client->editClient($request);
        if(isset($request->profilePhoto)){
            $this->client->uploadProfilePicture($request->profilePhoto, $request->clientId);
        }
        $title = "Client profile edited!";
        $log = Auth::user()->first_name." ".Auth::user()->last_name." edited client profile";
        ActivityLog::registerActivity(Auth::user()->org_id, $request->clientId, null, null, $title, $log);
        session()->flash("success", "Your changes were saved!");
        return back();
    }


    public function addClientGroup(Request $request){
        $this->validate($request,[
            'groupName'=>'required|unique:client_groups,group_name'
        ],[
            "groupName.required"=>"Enter client group name",
            "groupName.unique"=>"Client group name already taken.",
        ]);
        $this->clientgroup->addClientGroup($request);
        session()->flash("success", "Your client group was registered!");
        return back();
    }
    public function changeClientGroup(Request $request){
        $this->validate($request,[
            'groupName'=>'required',
            'groupId'=>'required',
        ],[
            "groupName.required"=>"Enter client group name",
            "groupName.unique"=>"Client group name already taken.",
        ]);
        $this->clientgroup->editClientGroup($request);
        session()->flash("success", "Your changes were saved!");
        return back();
    }

    public function viewClientProfile($slug){
        $client = $this->client->getClientBySlug($slug);
        if(!empty($client)){
            return view('clients.profile',[
                'client'=>$client,
                'files'=>$this->filemodel->getClientDocuments($client->id, Auth::user()->org_id),
                'users'=>$this->users->getAllOrganizationUsers(),
                'clientGroups'=>$this->clientgroup->getClientGroups()
            ]);
        }else{
            return back();
        }
    }

    public function assignClientTo(Request $request){
        $this->validate($request, [
            'assignTo'=>'required',
            'client'=>'required'
        ]);
        $this->client->assignClient($request->assignTo, $request->client);
        $user = $this->users->getUserById($request->assignTo);
        $client = $this->client->getClientById($request->client);
        if(!empty($user) && !empty($client)){
            $message = Auth::user()->first_name." ".Auth::user()->last_name." assigned ".$client->first_name." ".$client->last_name." to ".$user->first_name." ".$user->last_name;
            ActivityLog::registerActivity(Auth::user()->id, $request->client, null, null, 'Client Assignment', $message);
        }
        session()->flash("success", "Your assignment was successfully carried out.");
        return back();
    }

    public function archiveUnarchiveClient(Request $request){
        $this->validate($request,[
            'clientId'=>'required',
            'status'=>'required'
        ]);
        $this->client->archiveOrUnarchiveClient($request->clientId, $request->status);
        $status = $request->status == 1 ? 'unarchived' : 'archived';
        $title = "Client was ".$status;
        $message = Auth::user()->first_name." ".Auth::user()->last_name." ".$status." client account";
        ActivityLog::registerActivity(Auth::user()->org_id, $request->clientId, null,null, $title, $message);
        session()->flash("success", "Client was ".$status);
        return back();
    }
}
