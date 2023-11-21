<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Notice;
use Illuminate\Http\Request;
use App\Mail\SendMarkDownMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class AdminAccess extends Controller
{
    public function access(){

        if(!Gate::allows('access-admin')){
            abort('403');
        }else {
            # code...
            $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
            return view('racine_backend.index')->with('messages',$messages) ;
        }
        // Mail::to('koko@gmail.com')->send(new SendMail());
        // Mail::to('koko@gmail.com')->send(new SendMarkDownMail());

    }
}
