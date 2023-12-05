<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terms;
use Illuminate\Support\Facades\Session;

class TermsController extends Controller
{
    public function Terms(){
        Session::put('page','terms');
        $terms = Terms::get()->toArray();

        return view('admin.terms.adminterms')->with(compact('terms'));
    }   

    // Update Terms Status
    // public function updateTermsStatus(Request $request){
    //     if($request->ajax()){
    //         $data = $request->all();
    //         //making the inactive->active, vice versa
    //         if($data['status']=="Active"){
    //             $status = 0;
    //         } else{
    //             $status = 1;
    //         }
    //         Terms::where('id',$data['terms_id'])->update(['status'=>$status]);
    //         //return details into the ajax response so we can add the response as well
    //         return response()->json(['status'=>$status,'terms_id'=>$data['terms_id']]);
    //     }
    // }

    // Delete Terms
     public function deleteTerms($id){
        Session::put('page','terms');
        Terms::where('id',$id)->delete();
        $message = "Terms has been deleted successfully";
         return redirect()->back()->with('success_message',$message);
     }

     //Add-Edit Terms
     public function addEditTerms(Request $request,$id=null){
        Session::put('page','terms');
         if($id==""){
             $title = "Add Terms";
             $terms = new Terms;
             $message = "Terms Added Successfully";
         } else {
             Session::put('page','Terms');
             $title = "Edit Terms";
             $terms = Terms::find($id);
             $message = "Terms updated successfully";
         }
        
       if($request->isMethod('post')){
          $data = $request->all();

          // Array of Validation Rules
          $rules = [
                 'terms_name' => 'required|regex:/^[\pL\s\-]+$/u',
                 'terms_description' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
             $customMessages = [
                    'terms_name.required' => 'Terms Name is required!',
                     'terms_name.regex' => 'Valid Terms  Name is required!',
                     'terms_description.required' => 'Terms Description is required!',
                     'terms_nadescription.regex' => 'Valid Terms Descrption is required!',
                 ];
             $this->validate($request,$rules,$customMessages);
            $terms->name = $data['terms_name'];
            $terms->description = $data['terms_description'];
             $terms->save();
            
            $message = "Terms updated successfully";
             return redirect('admin/terms')->with('successs_message',$message);
         }

        //  if($request->isMethod('post')){
        //     $data = $request->all();
  
        //     // Array of Validation Rules
        //     $rules = [
        //            'terms_description' => 'required|regex:/^[\pL\s\-]+$/u',
        //       ];
        //        $customMessages = [
        //               'terms_description.required' => 'Terms Description is required!',
        //                'terms_description.regex' => 'Valid Terms  Description is required!',
        //            ];
        //        $this->validate($request,$rules,$customMessages);
        //       $terms->description = $data['terms_description'];
        //        $terms->save();
              
        //       $message = "Terms updated successfully";
        //        return redirect('admin/terms')->with('successs_message',$message);
        //    }
        
        return view('admin.Terms.add_edit_terms')->with(compact('title','terms'));
     }
}
