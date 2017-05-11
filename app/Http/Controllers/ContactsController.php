<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Client;
use App\Contact;


use Carbon\Carbon;

use Auth;

use File;
use Image;

class ContactsController extends Controller
{
    
    public function add($clientId)
    {
        $designations = DB::table('designations')->orderBy('position')->get(); 
        $client = Client::select('name','id')->where('id',base64_decode($clientId))->first();

        return view('clients.addContact',compact('clientId','designations','client'));
    }

  //--------------------------------------------------------------------------------------------------


   public function contactAddCheck(Request $request)
    {
          
          $name = $request->get('name'); 
          $id = $request->get('clientId'); 

          $count =Contact::whereRAW("name LIKE '%".$name."%'")->where('client',$id)
                            ->count();
            

        if($count)
        return response()->json(['valid' => 'false', 'message' => 'Similar Name exists in the database. Make sure you are not repeating','available'=>'false']);

        else
        return response()->json(['valid' => 'true', 'message' => ' ','available'=>'true']);
         
    } 

//------------------------------------------------------------------------------------------------------------------------------------------

 
    public function save($clientId,Request $request)
    {
        $this->validate($request, [
        'name' => 'required', 
        'position' => 'required',
        'mobile' => 'required|numeric',
        'phone' => 'numeric',
        'phone2' => 'numeric',
        'fileToUpload'=>'image|max:615|mimes:jpeg,jpg',]); 

          $clientId =  base64_decode($clientId);
 
          $contact = new Contact(array( 
                                    'name'=>ucwords(strtolower($request->name)),
                                    'client'=>$clientId,
                                    'position'=>$request->position,
                                    'mobile'=>$request->mobile,
                                    'phone'=>$request->phone,
                                    'phone2'=>$request->phone2,
                                    'email'=>$request->email,
                                    'notes'=>$request->notes,
                                    'addedBy'=>Auth::id(), 
                                   ));
                
                $contact->save();
                $contactId = $contact->id; 

                if($request->file('fileToUpload') && $contactId)
                {
                 $imageName = $contactId.'.jpg';  
                 Image::make($request->file('fileToUpload'))->save('../public/uploads/contactPics/'.$imageName); 
                } 

               return redirect()->action('ClientsController@profile',base64_encode($clientId))->with('status', 'New Contact added!');

         
    }  
//------------------------------------------------------------------------------------------------------------------------------------------  

public function deleteClientContact(Request $request)
   {
      $id = $request->id;

      Contact::where('id',$id)->update(['deleted' => 1,'deletedBy' => Auth::id()]);
 
        echo "<i class=\"fa fa-check-circle-o  text-danger\"></i>"; 
  }

//------------------------------------------------------------------------------------------------------------------------------------------


  public function restoreClientContact(Request $request)
   {
      $id = $request->id;

      Contact::where('id',$id)->update(['deleted' => 0,'deletedBy' => Auth::id()]);
 
        echo "<i class=\"fa fa-check-circle-o  text-success\"></i>"; 
  }

//------------------------------------------------------------------------------------------------------------------------------------------


public function edit($clientId,$contactId)
    {
        $designations = DB::table('designations')->orderBy('position')->get();  

        $contact = Contact::select('contacts.*','designations.position AS desig') 
                           ->leftjoin('designations','contacts.position', '=', 'designations.id')
                           ->where('contacts.id',base64_decode($contactId) ) 
                           ->first();

        return view('clients.editContact',compact('clientId','contactId','designations','contact'));
    }

//--------------------------------------------------------------------------------------------------


   public function contactEditCheck(Request $request)
    {
          
          $name = $request->get('name'); 
          $clientId = $request->get('clientId'); 
          $contactId = $request->get('contactId'); 

          $count =Contact::whereRAW("name LIKE '%".$name."%'")->where('client',$clientId)->where('id','!=',$contactId)->where('deleted',0)
                            ->count();
            

        if($count)
        return response()->json(['valid' => 'false', 'message' => 'Similar Name exists in the database. $contactIdMake sure you are not repeating','available'=>'false']);

        else
        return response()->json(['valid' => 'true', 'message' => ' ','available'=>'true']);
         
    }  

    //------------------------------------------------------------------------------------------------------------------------------------------

 
    public function editProcess($clientId,$contactId,Request $request)
    {
        $this->validate($request, [
        'name' => 'required', 
        'position' => 'required',
        'mobile' => 'required|numeric',
        'phone' => 'numeric',
        'phone2' => 'numeric',
        'fileToUpload'=>'image|max:615|mimes:jpeg,jpg',]); 

        $clientId =  base64_decode($clientId);
        $contactId =  base64_decode($contactId);

        $contact = Contact::where('id',$contactId)->first();
 
         $contact->name = ucwords(strtolower($request->name));
         $contact->position = $request->position;
         $contact->mobile = $request->mobile;
         $contact->phone = $request->phone;
         $contact->phone2 = $request->phone2;
         $contact->email = $request->email;
         $contact->notes = $request->notes;

         $contact->save();

         if($request->file('fileToUpload') && $contactId)
                {
                     if (File::exists('../public/uploads/contactPics/'.$contactId.'.jpg'))
                         File::delete('../public/uploads/contactPics/'.$contactId.'.jpg');

                 $imageName = $contactId.'.jpg';  
                 Image::make($request->file('fileToUpload'))->save('../public/uploads/contactPics/'.$imageName); 
                } 

        return redirect()->action('ClientsController@profile',base64_encode($clientId))->with('status', 'Contact Editted!');        
    }   

//--------------------------------------------------------------------------------------------------

   public function initiate()
    {  
         
        $countries = DB::table('Country')->orderBy('Name')->get();
        $industries = DB::table('industries')->orderBy('name')->get(); 
        $positions = DB::table('designations')->orderBy('position')->get(); 
        $contacts = 0;
         
        $industryFilter=0;
        $positionFilter=0; 
        $countryFilter=0; 
        $cityFilter=0; 

        return view('clients.filterContacts',compact('countries','industries','positions','contacts','industryFilter','positionFilter','countryFilter','cityFilter'));                     
    }

//--------------------------------------------------------------------------------------------
public function filterShow(Request $request)
    {  
         
        $countries = DB::table('Country')->orderBy('Name')->get();
        $industries = DB::table('industries')->orderBy('name')->get(); 
        $positions = DB::table('designations')->orderBy('position')->get(); 
 
        $filterString=" clients.deleted='0' AND contacts.deleted='0'";

        $industryFilter=0;
        $positionFilter=0; 
        $countryFilter=0; 
        $cityFilter=0; 
       
       if($request->industry)
       {
        $industryFilter=$request->industry;
        $chosenIndustry= DB::table('industries')->where('id',$industryFilter)->first(); 
        $filterString = $filterString." AND clients.industry='$industryFilter'";
       } 

       if($request->position)
       {
        $positionFilter=$request->position;
        $chosenPosition= DB::table('designations')->where('id',$positionFilter)->first(); 
        $filterString = $filterString." AND contacts.position='$positionFilter'";
       } 


       if($request->country) 
       {
        $countryFilter=$request->country;
        $chosenCountry= DB::table('Country')->where('Code',$countryFilter)->first();
        $filterString = $filterString." AND clients.country='$countryFilter'";
       }

       if($request->city)
       {
        $cityFilter=$request->city;
        $chosenCity= DB::table('City')->where('ID',$cityFilter)->first();
        $filterString = $filterString." AND clients.city='$cityFilter'";
       }


       $contacts = Contact::select('contacts.*','Country.Name AS countryName', 'City.Name AS cityName', 'clients.name AS clientName' ,'industries.name AS industryName','designations.position AS positionName')
                            ->leftjoin('clients','clients.id', '=', 'contacts.client')
                            ->leftjoin('Country','clients.country', '=', 'Country.Code')
                            ->leftjoin('City','clients.city', '=', 'City.ID') 
                            ->leftjoin('industries','clients.industry', '=', 'industries.id') 
                            ->leftjoin('designations','contacts.position', '=', 'designations.id') 
                            ->whereRaw($filterString)
                            ->orderBy('clients.name','contacts.name')
                            ->get();


        return view('clients.filterContacts',compact('countries','industries','contacts','positions','industryFilter','positionFilter','countryFilter','cityFilter','chosenIndustry','chosenPosition','chosenCountry','chosenCity'));                     
    }

//--------------------------------------------------------------------------------------------
public function searchBind(Request $request)
    {
        $keyword = $request->keyword;

        if($keyword=='')
            echo " ";
        else
        {
            $contacts = Contact::select('contacts.*','Country.Name AS countryName', 'City.Name AS cityName', 'clients.name AS clientName' ,'industries.name AS industryName','designations.position AS positionName')
                            ->leftjoin('clients','clients.id', '=', 'contacts.client')
                            ->leftjoin('Country','clients.country', '=', 'Country.Code')
                            ->leftjoin('City','clients.city', '=', 'City.ID') 
                            ->leftjoin('industries','clients.industry', '=', 'industries.id') 
                            ->leftjoin('designations','contacts.position', '=', 'designations.id') 
                            ->where(function($query){
                                     $query->where('contacts.deleted',0);
                             }) 
                             ->where(function($query) use ($keyword){
                                $query->orwhere('contacts.name', 'like', '%'.$keyword.'%');
                                $query->orWhere('mobile', 'like', '%'.$keyword.'%');
                                $query->orWhere('contacts.phone', 'like', '%'.$keyword.'%');
                                $query->orWhere('phone2', 'like', '%'.$keyword.'%');
                             }) 
                            ->orderBy('clients.name','contacts.name')
                            ->get();
                            ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="nosort">#</th>
                                        <th>Name</th>
                                        <th>Company</th> 
                                        <th>Industry</th> 
                                        <th>Position</th> 
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Mobile</th> 
                                        <th>Phone</th> 
                                        <th>Email</th> 
                                    </tr>
                                </thead>
                                <tbody> 
                                     <?php foreach($contacts As $index => $contact)  { ?>
                                    <tr>
                                        <td><?php echo $index+1 ;?></td> 
                                        <td><?php echo str_ireplace($keyword,"<span class=\"text-danger\">".$keyword."</span>",$contact->name);?></td> 
                                        <td><a href="\hrm\clients\<?php echo base64_encode($contact->client) ?>\profile"><?php echo $contact->clientName; ?></a></td>
                                        <td><?php echo  $contact->industryName; ?> </td>
                                        <td><?php echo  $contact->positionName; ?> </td>
                                        <td><?php echo  $contact->countryName; ?> </td>
                                        <td><?php if($contact->city)  echo $contact->cityName; else echo "Multiple Cities"; ?></td>
                                        <td><?php echo str_ireplace($keyword,"<span class=\"text-danger\">".$keyword."</span>",$contact->mobile);?></td>
                                         <td><?php echo str_ireplace($keyword,"<span class=\"text-danger\">".$keyword."</span>",$contact->phone);  if($contact->phone2)   echo ", ".str_ireplace($keyword,"<span class=\"text-danger\">".$keyword."</span>",$contact->phone2); ?></td>
                                        <td><?php echo $contact->email ?></td>
                                         
                                    </tr>
                                     
                            <?php } ?>
                                     
                                </tbody>
                            </table>
                            <?php
        }
    }
//--------------------------------------------------------------------------------------------


}
