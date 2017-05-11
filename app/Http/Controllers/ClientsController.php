<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\ClientAddRequest;


use DB;
use App\Client;
use App\Contact;
use App\ClientCall;

use Carbon\Carbon;

use Auth;

use File;
use Image;

class ClientsController extends Controller
{

    public function index()
    {  
 
        $clients = Client::select(array('clients.*','Country.Name AS countryName', 'City.Name AS cityName', 'status.status AS currentStatus' , 'industries.name AS industryName',DB::raw('(SELECT count(id) FROM contacts WHERE contacts.client = clients.id AND deleted=0) AS addedContacts'),DB::raw('(SELECT count(id) FROM clientCalls WHERE clientCalls.client = clients.id) AS addedCalls')))  
                            ->leftjoin('Country','clients.country', '=', 'Country.Code')
                            ->leftjoin('City','clients.city', '=', 'City.ID')
                            ->leftjoin('status','clients.status', '=', 'status.id') 
                            ->leftjoin('industries','clients.industry', '=', 'industries.id') 
                            ->where('deleted',0)
                            ->orderBy('clients.name')
                            ->get();

       return view('clients.index',compact('clients'));                     
    }

   //------------------------------------------------------------------------------------------------------------------------------------------


    public function add()
    {
        $countries = DB::table('Country')->orderBy('Name')->get();
        $industries = DB::table('industries')->orderBy('name')->get(); 
        $clients = Client::orderBy('name')->get(); 
        $status = DB::table('status')->get(); 


        return view('clients.addClient',compact('countries','industries','clients','status'));
    }


//------------------------------------------------------------------------------------------------------------------------------------------

   public function cityLoader(Request $request)
    {
        $country = $request->country;
        
           
            $cities = DB::table('City')
                        ->where('CountryCode',$country)  
                        ->get();
                ?>
                    <select class="form-control" name="city"  data-fv-notempty="true" >
                    <option value="0" >Multiple Cities</option>
                    <?php  
                        foreach($cities AS $city) { ?>
                        <option value="<?php echo $city->ID; ?>" ><?php echo $city->Name; ?></option>
                    <?php } ?> 
                    </select> 
                <?php
        
    }


//------------------------------------------------------------------------------------------------------------------------------------------

 public function clientAddCheck(Request $request)
    {
          
          $name = $request->get('name'); 

          $count = Client::whereRAW("name LIKE '%".$name."%'")
                            ->count();
            

        if($count)
        return response()->json(['valid' => 'false', 'message' => 'Name exists in the database. Make sure you are not repeating','available'=>'false']);

        else
        return response()->json(['valid' => 'true', 'message' => ' ','available'=>'true']);
         
    } 

//------------------------------------------------------------------------------------------------------------------------------------------

 public function clientEditCheck(Request $request)
    {
          
          $name = $request->get('name'); 

          $count = Client::whereRAW("name LIKE '%".$name."%'")->where('id','!=',$request->clientId)
                            ->count();
            

        if($count)
        return response()->json(['valid' => 'false', 'message' => 'Name exists in the database. Make sure you are not repeating','available'=>'false']);

        else
        return response()->json(['valid' => 'true', 'message' => ' ','available'=>'true']);
         
    } 

//------------------------------------------------------------------------------------------------------------------------------------------

    public function save(ClientAddRequest $request)
    {
          
           $name = ucwords(($request->name));
  
             $client = new Client(array( 
                                    'name'=>$name,
                                    'industry'=>$request->industry,
                                    'status'=>$request->status,
                                    'parent_company'=>$request->parent_company,
                                    'url'=>$request->url,
                                    'phone'=>$request->phone,
                                    'country'=>$request->country,
                                    'city'=>$request->city,
                                    'description'=>$request->description,
                                    'address'=>$request->address,
                                    'postal_code'=>$request->postal_code,
                                    'coordinates'=>$request->coordinates,
                                    'added_by'=>Auth::id(), 
                                   ));
                
                $client->save();
                $clientId = $client->id; 

                if($request->file('fileToUpload') && $clientId)
                {
                 $imageName = $clientId.'.jpg';  
                 Image::make($request->file('fileToUpload'))->save('../public/uploads/clientLogos/'.$imageName); 
                // Storage::put('/public/clientLogos/'.$imageName, $request->file('fileToUpload'));
                } 

               return redirect()->action('ClientsController@profile',base64_encode($clientId))->with('status', 'New Client added!');

         
    }  

//------------------------------------------------------------------------------------------------------------------------------------------

    public function profile($clientId)
    {
         $clientId = base64_decode($clientId);

         $client = Client::select('clients.*','Country.Name AS countryName', 'City.Name AS cityName', 'status.status AS currentStatus' ,'industries.name AS industryName','parenter.name AS parentCompany','users.name AS addedBy')
                            ->leftjoin('Country','clients.country', '=', 'Country.Code')
                            ->leftjoin('City','clients.city', '=', 'City.ID')
                            ->leftjoin('status','clients.status', '=', 'status.id')
                            ->leftjoin('industries','clients.industry', '=', 'industries.id')
                            ->leftjoin('users','clients.added_by', '=', 'users.id')
                            ->leftjoin('clients AS parenter','clients.parent_company', '=', 'parenter.id')
                            ->where('clients.id',$clientId)
                            ->first();
       
        $contacts = Contact::select('contacts.*','designations.position AS desig','users.name AS admin')
                           ->leftjoin('users','contacts.addedBy', '=', 'users.id')
                           ->leftjoin('designations','contacts.position', '=', 'designations.id')
                           ->where('contacts.client',$clientId)
                           ->where('contacts.deleted',0)
                           ->orderBy('contacts.name')
                           ->get();
        

        $calls = ClientCall::select('clientCalls.*','contacts.name AS contactName','users.name AS admin')
                           ->leftjoin('users','clientCalls.added_by', '=', 'users.id')
                           ->leftjoin('contacts','contacts.id', '=', 'clientCalls.contact_person_id')
                           ->where('clientCalls.client',$clientId) 
                           ->orderBy('clientCalls.call_time','desc')
                           ->get();


        foreach($contacts AS $contact)
        {
            if (File::exists('../public/uploads/contactPics/'.$contact->id.'.jpg'))
            $contact->pic = 1 ; 
            else 
            $contact->pic=0;
        }

         $deletedContacts = Contact::select('contacts.*','designations.position AS desig','users.name AS admin')
                           ->leftjoin('users','contacts.deletedBy', '=', 'users.id')
                           ->leftjoin('designations','contacts.position', '=', 'designations.id')
                           ->where('contacts.client',$clientId)
                           ->where('contacts.deleted',1)
                           ->orderBy('contacts.name')
                           ->get();


        $subsidiaries = Client::select('name','id')->where('parent_company',$clientId)->get();  

         $changes = DB::table('clientsHistory')
                     ->select('clientsHistory.*','users.name AS addedBy')
                     ->leftjoin('users','clientsHistory.admin', '=', 'users.id')
                     ->where('client_id',$clientId) 
                     ->orderBy('dated','desc') 
                     ->get();                   
 
       if (File::exists('../public/uploads/clientLogos/'.$clientId.'.jpg'))
            $profile_pic = '/uploads/clientLogos/'.$clientId.'.jpg' ; 
       else
            $profile_pic = '/uploads/clientLogos/no_image.jpg';                   

          return view('clients.profile',compact('clientId','client','profile_pic','subsidiaries','changes','contacts','deletedContacts','calls'));
    }

//------------------------------------------------------------------------------------------------------------------------------------------

   public function edit($clientId)
    {
         $clientId = base64_decode($clientId);

        $countries = DB::table('Country')->orderBy('Name')->get();
        $industries = DB::table('industries')->orderBy('name')->get(); 
        $clients = Client::orderBy('name')->where('id','!=',$clientId)->get(); 
        $status = DB::table('status')->get(); 

         $client = Client::select('clients.*','Country.Name AS countryName', 'City.Name AS cityName', 'status.status AS currentStatus'  ,'industries.name AS industryName','parenter.name AS parentCompany','users.name AS addedBy')
                            ->leftjoin('Country','clients.country', '=', 'Country.Code')
                            ->leftjoin('City','clients.city', '=', 'City.ID')
                            ->leftjoin('status','clients.status', '=', 'status.id') 
                            ->leftjoin('industries','clients.industry', '=', 'industries.id')
                            ->leftjoin('users','clients.added_by', '=', 'users.id')
                            ->leftjoin('clients AS parenter','clients.parent_company', '=', 'parenter.id')
                            ->where('clients.id',$clientId)
                            ->first();

        $subsidiaries = Client::select('name','id')->where('parent_company',$clientId)->get();  

                      

       if (File::exists('../public/uploads/clientLogos/'.$clientId.'.jpg'))
            $profile_pic = '/uploads/clientLogos/'.$clientId.'.jpg' ; 
       else
            $profile_pic = '';    
           

        return view('clients.editClient',compact('clientId','client','profile_pic','subsidiaries','countries','industries','clients','status'));
    }

//------------------------------------------------------------------------------------------------------------------------------------------

    public function editProcess(ClientAddRequest $request,$clientId)
    {
             $clientId = base64_decode($clientId);

             $client = Client::select('clients.*','Country.Name AS countryName', 'City.Name AS cityName', 'status.status AS currentStatus' ,'industries.name AS industryName','parenter.name AS parentCompany','users.name AS addedBy')
                            ->leftjoin('Country','clients.country', '=', 'Country.Code')
                            ->leftjoin('City','clients.city', '=', 'City.ID')
                            ->leftjoin('status','clients.status', '=', 'status.id')
                            ->leftjoin('industries','clients.industry', '=', 'industries.id')
                            ->leftjoin('users','clients.added_by', '=', 'users.id')
                            ->leftjoin('clients AS parenter','clients.parent_company', '=', 'parenter.id')
                            ->where('clients.id',$clientId)
                            ->first();

             $historyString = "";

            if($client->name!=ucwords(($request->name)))
                $historyString = $historyString."Name : ".$client->name."=>".$request->name."<br>";

            if($client->industry != $request->industry)
                {
                    $industry = DB::table('industries')->where('id',$request->industry)->first();
                    $historyString = $historyString."Industry : ".$client->industryName."=>".$industry->name."<br>";
                }

            if($client->status != $request->status)
                {
                    $status = DB::table('status')->where('id',$request->status)->first();
                    $historyString = $historyString."Status : ".$client->currentStatus."=>".$status->status."<br>";
                }

           

            if($client->parent_company != $request->parent_company)
                {   
                   $temp1 =  $temp2 = "None";  

                   if($client->parent_company!=0)
                    {
                        $parentCompany1 = Client::where('id',$client->parent_company)->first();
                        $temp1 = $parentCompany1->name;
                    }           

                    if($request->parent_company!=0)
                    {
                        $parentCompany2 = Client::where('id',$request->parent_company)->first();
                        $temp2 = $parentCompany2->name;
                    }
                    
                    
                    $historyString = $historyString."Parent Company : ".$temp1."=>".$temp2."<br>";
                }        
                    
            if($client->url!=$request->url)
                $historyString = $historyString."URL Changed<br>";

            if($client->phone!=$request->phone)
                $historyString = $historyString."Phone : ".$client->phone."=>".$request->phone."<br>";

            if($client->country!=$request->country || $client->city!=$request->city || $client->address!=$request->address || $client->postal_code!=$request->postal_code)
                $historyString = $historyString."Address/Location changed<br>";
 			
 			if($client->coordinates != $request->coordinates)
                {
                     
                    $historyString = $historyString."Coordinates : ".$client->coordinates."=>".$request->coordinates."<br>";
                }

             if($client->description!=$request->description)
                $historyString = $historyString."Company description changed<br>";

                        $client->name = ucwords(($request->name));
                        $client->industry = $request->industry;
                        $client->status = $request->status;
                        $client->coordinates = $request->coordinates;
                        $client->parent_company = $request->parent_company;
                        $client->url = $request->url;
                        $client->phone = $request->phone;
                        $client->country = $request->country;
                        $client->city = $request->city;
                        $client->description = $request->description;
                        $client->address = $request->address;
                        $client->postal_code = $request->postal_code;

                        $client->save(); 

                if($request->file('fileToUpload'))
                {
                    if (File::exists('../public/uploads/clientLogos/'.$clientId.'.jpg'))
                         File::delete('../public/uploads/clientLogos/'.$clientId.'.jpg');

                 $imageName = $clientId.'.jpg';  
                 Image::make($request->file('fileToUpload'))->save('../public/uploads/clientLogos/'.$imageName); 

                 $historyString = $historyString."Logo Changed";
                } 

                if($historyString)
                DB::table('clientsHistory')->insert(['client_id' => $clientId,'admin' => Auth::id(),'changes' => $historyString,'dated' => Carbon::now()]);

               return redirect()->action('ClientsController@profile',base64_encode($clientId))->with('status', 'Editted succesfully!');

         
    }  

//------------------------------------------------------------------------------------------------------------------------------------------

}
?>