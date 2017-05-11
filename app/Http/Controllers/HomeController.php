<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Client;
use App\Contact;
use App\ClientCall;

use Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
         $dated = date('Y-m-d', strtotime("-15 days"));
         $today = date('Y-m-d');
         $totalClients = Client::where('deleted',0)->count();
         $newClients = Client::where('created_at','>',$dated)->count();
         $totalContacts = Contact::where('deleted',0)->count();
         $newCalls = ClientCall::whereRaw("created_at LIKE '%".$today."%'")->count(); 

         $saudiClients = Client::where('deleted',0)->where('country','SAU')->count();
         $qatarClients = Client::where('deleted',0)->where('country','QAT')->count();
         $uaeClients = Client::where('deleted',0)->where('country','ARE')->count();

         $month1 = date('Y-m-d');
         $datestring=$month1.' first day of last month';
         $dt=date_create($datestring);
         $month1=  date('Y-m',strtotime($month1));
         $month2= $dt->format('Y-m');  

         $datestring=$month2.'-01 first day of last month';
         $dt=date_create($datestring);
         $month3= $dt->format('Y-m');  

         $datestring=$month3.'-01 first day of last month';
         $dt=date_create($datestring);
         $month4= $dt->format('Y-m'); 

         $datestring=$month4.'-01 first day of last month';
         $dt=date_create($datestring);
         $month5= $dt->format('Y-m');  

         $datestring=$month5.'-01 first day of last month';
         $dt=date_create($datestring);
         $month6= $dt->format('Y-m'); 

         $months = [ "0" => date('M',strtotime($month6.'-01')), "1" => date('M',strtotime($month5.'-01')), "2" => date('M',strtotime($month4.'-01')), "3" => date('M',strtotime($month3.'-01')), "4" => date('M',strtotime($month2.'-01')), "5" => date('M',strtotime($month1.'-01')),];

         $inboundCalls = [];

         $inboundCalls[0] = ClientCall::whereRaw("created_at LIKE '%".$month6."%'")->where('call_type',1)->count(); 
         $inboundCalls[1] = ClientCall::whereRaw("created_at LIKE '%".$month5."%'")->where('call_type',1)->count(); 
         $inboundCalls[2] = ClientCall::whereRaw("created_at LIKE '%".$month4."%'")->where('call_type',1)->count(); 
         $inboundCalls[3] = ClientCall::whereRaw("created_at LIKE '%".$month3."%'")->where('call_type',1)->count(); 
         $inboundCalls[4] = ClientCall::whereRaw("created_at LIKE '%".$month2."%'")->where('call_type',1)->count(); 
         $inboundCalls[5] = ClientCall::whereRaw("created_at LIKE '%".$month1."%'")->where('call_type',1)->count(); 

         $outboundCalls = [];

         $outboundCalls[0] = ClientCall::whereRaw("created_at LIKE '%".$month6."%'")->where('call_type',2)->count(); 
         $outboundCalls[1] = ClientCall::whereRaw("created_at LIKE '%".$month5."%'")->where('call_type',2)->count(); 
         $outboundCalls[2] = ClientCall::whereRaw("created_at LIKE '%".$month4."%'")->where('call_type',2)->count(); 
         $outboundCalls[3] = ClientCall::whereRaw("created_at LIKE '%".$month3."%'")->where('call_type',2)->count(); 
         $outboundCalls[4] = ClientCall::whereRaw("created_at LIKE '%".$month2."%'")->where('call_type',2)->count(); 
         $outboundCalls[5] = ClientCall::whereRaw("created_at LIKE '%".$month1."%'")->where('call_type',2)->count();


        //echo("<script>console.log('PHP: ".json_encode($month6)."');</script>");
         
         $industries = DB::table('clients')
                 ->select('industry', DB::raw('count(*) as counter'),'industries.name AS industryName')
                 ->leftjoin('industries','clients.industry', '=', 'industries.id')
                 ->where('deleted',0)
                 ->groupBy('industry')
                 ->get();
 
         return view('dashboard',compact('totalClients','newClients','totalContacts','newCalls','industries','months','inboundCalls','outboundCalls','saudiClients','qatarClients','uaeClients'));    
    }

     
}
