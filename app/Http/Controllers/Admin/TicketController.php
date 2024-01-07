<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Tickets;
class TicketController extends Controller
{

    public function index(){
           return view('admin.tickets.tickets');
    }

    public function request(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $ticket = new Tickets;
            $ticket->vendor_id = $data['vendor_id'];
            $ticket->message = $data['message'];
            $ticket->ticket_type = 'request';
            $ticket->save();

            $message = "Request Submitted";
            return redirect()->back()->with('success_message',$message);
        }
    
    }
}
