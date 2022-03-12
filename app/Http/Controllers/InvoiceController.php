<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Echo_;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        $remainingHours = 25;

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'image' => ['required','mimes:png,jpg,jpeg','max:1024']
        ]);
        $current_user_id = Auth::id();
        $invoices = Invoice::where('user_id',$current_user_id)->orderBy('created_at','DESC')->get()->toArray();

        if(count($invoices)>0){
           $now = \Carbon\Carbon::now();   //current time from carbon
           $endDate = \Carbon\Carbon::parse($invoices[0]["created_at"]); //last created time
           $remainingHours = $now->diffInHours($endDate); //calculating difference of times
        }



        if($remainingHours>24){
                 $path = $request->file('image')->store('storage');
                if($path){

                    $invoice = Invoice::create([
                        'title' => $request->title,
                        'message' => $request->message,
                        'img_url'=>$path,
                        'user_id'=>$current_user_id
                    ]);

                    return back()->with('message', 'Success');;

                }
        }

        return back()->with('message', 'Please wait while, you allowed to send at each 24 hours.');;

    }


    public function invoices(Request $request){

        $invoices = Invoice::orderBy('created_at', 'DESC')->with('user')->paginate(10);

        return view('manager',compact('invoices'));
    }

    public function check($invoice_id){
        $invoice = Invoice::find($invoice_id);
        $invoice->checked = 1;

        if($invoice->save()){
            return back();
        }

    }
}
