<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Models\IdentifiantUser;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;

class VoirLienFront extends Controller
{
    //

    public function liens($id){
// dd(Auth::user()->id);

$messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        // $encrypted = Crypt::encryptString($id);

        // dd( $encrypted);


// if (!Gate::allows('access-liens')) {
//     # code...
//     abort('403') ;
// }
$tous_les_liens_avec_clics = IdentifiantUser::where('user_id',$id)->get();
if($id!=Auth::user()->id){
    abort('403') ;
}

if(!Gate::allows('access-vendeur')){
    abort('403');
}else{
    return view('frontend.voir_liens_front')->with('tous_les_liens_avec_clics',$tous_les_liens_avec_clics)->with('messages',$messages);
}


    }
}
