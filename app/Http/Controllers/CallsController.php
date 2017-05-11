<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Client;
use App\Contact;
use App\ClientCall;
use Carbon\Carbon;

use Auth; 


class CallsController extends Controller
{
   
    public function add($clientId)
    {
         
        $client = Client::select('name','id')->where('id',base64_decode($clientId))->first();
        $contacts =Contact::select('name','id')->where('client',base64_decode($clientId))->orderBy('name')->get(); 

        return view('clients.addCall',compact('clientId','client','contacts'));
    }

//--------------------------------------------------------------------------------------------------------------------------------------------------
   
   public function save($clientId,Request $request)
    {
         
          $this->validate($request, [
        'contact_person_id' => 'required_without_all:contact_person',
        'contact_person' => 'required_without_all:contact_person_id',
        'call_time' => 'required',
        'call_type' => 'required',
        'importance' => 'required',
        'call_details' => 'required',]); 

          $clientId =  base64_decode($clientId);

          if($request->contact_person_id)
            $contact_person='';
          else 
            $contact_person = ucwords(strtolower($request->contact_person));
            
 
          $call = new ClientCall(array( 
                                    'contact_person_id'=>$request->contact_person_id,
                                    'contact_person'=>$contact_person,
                                    'client'=>$clientId,
                                    'call_time'=>$request->call_time,
                                    'call_type'=>$request->call_type,
                                    'importance'=>$request->importance,
                                    'call_details'=>$request->call_details,
                                    'added_by'=>Auth::id(), 
                                   ));
                
            $call->save();
                

               return redirect()->action('ClientsController@profile',base64_encode($clientId))->with('status', 'New Call saved!');
    }

//------------------------------------------------------------------------------------------------------------------------------------------


public function edit($clientId,$callId)
    {
        $client = Client::select('name','id')->where('id',base64_decode($clientId))->first(); 
        $contacts =Contact::select('name','id')->where('client',base64_decode($clientId))->orderBy('name')->get(); 

        $call = ClientCall::select('clientCalls.*','contacts.name AS contactName')
                           ->leftjoin('users','clientCalls.added_by', '=', 'users.id')
                           ->leftjoin('contacts','contacts.id', '=', 'clientCalls.contact_person_id')
                           ->where('clientCalls.id',base64_decode($callId) )  
                           ->first(); 

        return view('clients.editCall',compact('clientId','callId','call','client','contacts'));
    }

//--------------------------------------------------------------------------------------------------------------------------------------------------
   
   public function editProcess($clientId,$callId,Request $request)
    {
         
          $this->validate($request, [
        'contact_person_id' => 'required_without_all:contact_person',
        'contact_person' => 'required_without_all:contact_person_id',
        'call_time' => 'required',
        'call_type' => 'required',
        'importance' => 'required',
        'call_details' => 'required',]); 

          $clientId =  base64_decode($clientId);
          $callId =  base64_decode($callId);

          if($request->contact_person_id)
            $contact_person='';
          else 
            $contact_person = ucwords(strtolower($request->contact_person));
            
 
         $call = ClientCall::where('id',$callId)->first();  
              
             $call->contact_person_id = $request->contact_person_id;
             $call->contact_person = $contact_person;
             $call->call_time = $request->call_time;
             $call->call_type = $request->call_type;
             $call->importance = $request->importance;
             $call->call_details = $request->call_details; 

         $call->save();
                

        return redirect()->action('ClientsController@profile',base64_encode($clientId))->with('status', 'Call editted!');
    }    

//--------------------------------------------------------------------------------------------------------------------------------------------------
   
   public function delete($clientId,$callId)
    {
        $deletion = ClientCall::where('id', base64_decode($callId))->delete();
        return redirect()->action('ClientsController@profile',$clientId)->with('status', 'Call removed!');
    }    
//--------------------------------------------------------------------------------------------------------------------------------------------------

}
