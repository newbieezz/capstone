<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tickets;
class TicketController extends Controller
{
    public function feedback(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
            $ticket = new Tickets;
            $ticket->user_id = $data['user_id'];
            $ticket->message = $data['message'];
            $ticket->ticket_type = 'feedback';
            $ticket->save();

            $message = "Feedback Submitted ";
            return redirect()->back()->with('success_message',$message);

        }
    }
}
