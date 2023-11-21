<?php

namespace App\Http\Controllers;

use App\Events\NoticeMessageEvent;
use App\Models\User;
use App\Models\Notice;
use App\Notifications\AdminMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AutorisationRefuseNotification;
use App\Notifications\AutorisationAccepteNotification;

class AdminControllerVendeur extends Controller
{
    public function affiche_vendeurs(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $vendeurs = User::orderBy('created_at','desc')->get();

        return view('backend.affiche_vendeurs')->with('vendeurs',$vendeurs)->with('messages',$messages)  ;
    }
    public function supprimer_vendeurs($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $vendeurs = User::find($id);
        $vendeurs->delete() ;
        return redirect('/affiche_tous_vendeurs')->with('status',"vous avez supprimé Mr || Mme ".$vendeurs->name)->with('messages',$messages)  ;
    }
    public function activer_vendeurs($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $vendeurs = User::find($id);
        $vendeurs->status=2;
        $vendeurs->update();
        // on ajoute un email pour l'autorisation
        $vendeurs->notify(new AutorisationAccepteNotification($vendeurs)) ;
        return redirect('/affiche_tous_vendeurs')->with('status',"vous avez autorisé Mr || Mme ".$vendeurs->name.' à etre votre vendeurs')->with('messages',$messages)  ;
    }
    public function desactiver_vendeurs($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $vendeurs = User::find($id);
        $vendeurs->status=3;
        $vendeurs->update();
        // on ajoute un email pour banir
        $vendeurs->notify(new AutorisationRefuseNotification($vendeurs)) ;
        return redirect('/affiche_tous_vendeurs')->with('status',"vous avez bannie Mr || Mme ".$vendeurs->name.' à etre votre vendeurs')->with('messages',$messages)  ;
    }
// ***********************admin ******************************
    public function activer_admin($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $admin = User::find($id);
        $admin->admin=1;
        $admin->update();
// on ajoute un email pour l'autorisation
$admin->notify(new AutorisationAccepteNotification($admin)) ;
        return redirect('/affiche_tous_vendeurs')->with('status'," Nouveau Admin || Mme ".$admin->name.'!')->with('messages',$messages)  ;

    }
    public function desactiver_admin($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $admin = User::find($id);
        $admin->admin=0;
        $admin->update();
        // on ajoute un email pour banir
        $admin->notify(new AutorisationRefuseNotification($admin)) ;
        return redirect('/affiche_tous_vendeurs')->with('status',"vous avez annulé l'autorisation de Mr || Mme ".$admin->name.'!')->with('messages',$messages)  ;
    }
    // *********************************admin*********************

    public function affiche_tous_vendeurs_apr(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $vendeurs = User::get();
        return view('backend.affiche_tous_vendeur_apr')->with('vendeurs',$vendeurs)->with('messages',$messages)  ;
    }

    public function desactiver_vendeurs_apr($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $vendeurs = User::find($id);
        $vendeurs->status=0;
        $vendeurs->update();
        // on ajoute un email pour banir
        //$vendeurs->notify(new AutorisationRefuseNotification($vendeurs)) ;
        return redirect('/affiche_tous_vendeurs_apr')->with('status',"vous avez bannie Mr || Mme ".$vendeurs->name.' à etre votre vendeurs')->with('messages',$messages)  ;
    }
    public function affiche_tous_vendeurs_npr(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $vendeurs = User::get();
return view('backend.affiche_tous_vendeurs_npr')->with('vendeurs',$vendeurs)->with('messages',$messages)  ;
        // return view('bac')->with('vendeurs',$vendeurs) ;
    }
    public function desactiver_vendeurs_npr($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $vendeurs = User::find($id);
        $vendeurs->status=2;
        $vendeurs->update();
        // on ajoute un email pour banir
        //$vendeurs->notify(new AutorisationRefuseNotification($vendeurs)) ;
        return redirect('/affiche_tous_vendeurs_npr')->with('status',"vous avez autorisé Mr || Mme ".$vendeurs->name.' à etre votre vendeurs')->with('messages',$messages)  ;
    }

    public function notice($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
//    dd($id);
  $vendeurs = User::where('id',$id)->get();
//   dd($vendeurs);
return view('backend.notice')->with('vendeurs',$vendeurs)->with('messages',$messages) ;

    }

    public function notice_envoie(Request $request){

        $this->validate($request,[
            'message'=>'required',
        ]) ;

      $notice = new Notice();
      $notice->name_sender = Auth::user()->name;
      $notice->id_receive =$request->id_receive ;
      $notice->id_sender= Auth::user()->id;
      $notice->message =$request->message;
      $notice->save();

    //    $messages = Notice::where('id_receive',Auth::user()->id)->get();

    //    foreach ($messages as $message) {
    //  $msg =$message->message ;
    //    }

      $user = User::find($request->id_receive);

      $user->notify(new AdminMessageNotification($user,$request->message));
    //   event(new NoticeMessageEvent(Auth::user()->name ,$request->id_receive, Auth::user()->id,$request->message));

    //   return response()->json([
    //     'success'=>'chat message sent'
    //   ]);



      return back()->with("message","message envoyé avec succès !") ;




    }

    public function notice_affiche(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('racine_backend.index')->with('messages',$messages) ;
    }

    public function delete_notice($id){
$notice = Notice::find($id);
$notice->delete() ;

return back()->with('message_alert', 'message supprimé avec success !');
    }
}
