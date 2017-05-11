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


class ClientsControllerExtra extends Controller
{
    public function initiate()
    {  
         
        $countries = DB::table('Country')->orderBy('Name')->get();
        $industries = DB::table('industries')->orderBy('name')->get(); 
        $clients = 0;
        $status = DB::table('status')->get(); 

        $industryFilter=0;
        $statusFilter=0;
        $bd_gradeFilter=0;
        $countryFilter=0;
        $cityFilter=0; 

        return view('clients.filterClients',compact('countries','industries','clients','status','industryFilter','statusFilter','countryFilter','cityFilter'));                     
    }


//--------------------------------------------------------------------------------------------
public function filterShow(Request $request)
    {  
         
        $countries = DB::table('Country')->orderBy('Name')->get();
        $industries = DB::table('industries')->orderBy('name')->get();  
        $status = DB::table('status')->get(); 
 
        $filterString=" deleted='0' ";

        $industryFilter=0;
        $statusFilter=0; 
        $countryFilter=0;
        $cityFilter=0; 
       
       if($request->industry)
       {
        $industryFilter=$request->industry;
        $chosenIndustry= DB::table('industries')->where('id',$industryFilter)->first(); 
        $filterString = $filterString." AND clients.industry='$industryFilter'";
       } 

       if($request->status)
       {
        $statusFilter=$request->status;
        $chosenStatus= DB::table('status')->where('id',$statusFilter)->first(); 
        $filterString = $filterString." AND clients.status='$statusFilter'";
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


       $clients = Client::select(array('clients.*','Country.Name AS countryName', 'City.Name AS cityName', 'status.status AS currentStatus' ,'industries.name AS industryName',DB::raw('(SELECT count(id) FROM contacts WHERE contacts.client = clients.id) AS addedContacts'),DB::raw('(SELECT count(id) FROM clientCalls WHERE clientCalls.client = clients.id) AS addedCalls')))
                            ->leftjoin('Country','clients.country', '=', 'Country.Code')
                            ->leftjoin('City','clients.city', '=', 'City.ID')
                            ->leftjoin('status','clients.status', '=', 'status.id') 
                            ->leftjoin('industries','clients.industry', '=', 'industries.id') 
                            ->whereRaw($filterString)
                            ->orderBy('clients.name')
                            ->get();


        return view('clients.filterClients',compact('countries','industries','clients','status','industryFilter','statusFilter','countryFilter','cityFilter','chosenIndustry','chosenStatus','chosenGrade','chosenCountry','chosenCity'));                     
    }



}
