<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notice;
use App\Models\Product;
use App\Models\ClicLien;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClientAccess extends Controller
{
    //

    public function access(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        return view('racinde_frontend.index')->with('messages',$messages) ;
    }

    public function access_panneau(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();

        // dd($messages->count());
        // if(!Gate::allows('access-vendeur')){
        //     abort('403');

        //   //   on envoie un email pour informer les vendeurs d'attendre sa validation
        // }


        $categories =  Categorie::get();
        $produits = Product::where('status',1)->paginate(2);

        if(!Gate::allows('access-vendeur')){
            abort('403');
        }else {
            # code...
            return view('frontend.accueil_panneau')->with('categories',$categories)->with('produits',$produits)->with('messages',$messages);
        }

    }

    public function select_categorie($nom){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $categories =  Categorie::get();
        $produits = Product::where('status',1)->where("nom_categorie",$nom)->paginate(2);
        return view('frontend.accueil_panneau')->with('categories',$categories)->with('produits',$produits)->with('messages',$messages);
    }
    public function campagnes(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();

        $categories =  Categorie::get();
        $produits = Product::where('status',1)->paginate(2);
        if(!Gate::allows('access-vendeur')){
            abort('403');
        }else {
            # code...
            return view('frontend.campagnes')->with('categories',$categories)->with('produits',$produits)->with('messages',$messages) ;
        }

    }
    public function select_categorie_campagnes($nom){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $categories =  Categorie::get();
        $produits = Product::where('status',1)->where("nom_categorie",$nom)->paginate(2);
        return view('frontend.campagnes')->with('categories',$categories)->with('produits',$produits)->with('messages',$messages);
    }
    public function appeller_url($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();
        $produits= Product::all()->where('id',$id);

          return view('frontend.affiche_liens_offres')->with('produits',$produits)->with('messages',$messages);
    }

    public function clics(){


        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('message','asc')->get();

        $clic_liens = ClicLien::where('user_id',Auth::user()->id)->get() ;

        if(!Gate::allows('access-vendeur')){
            abort('403');
        }else{
            return view('frontend.clics')->with('messages',$messages)->with('clic_liens',$clic_liens) ;

        }



    }

    public function messages(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $users = User::where('admin',1)->get();
        return view('frontend.messages')->with('users',$users)->with('messages',$messages) ;
    }

    public function chat_conserve(Request $request){

        $this->validate($request,[
            'message'=>'required',
        ]) ;

      $notice = new Notice();
      $notice->name_sender = Auth::user()->name;
      $notice->id_receive =$request->id_receive ;
      $notice->id_sender= Auth::user()->id;
      $notice->message =$request->message;
      $notice->save();

      return back()->with("message","message envoyé avec succès !") ;


    }

    public function delete_notice($id){
        $notice = Notice::find($id) ;
        $notice->delete() ;

        return back()->with('message_alert', 'message supprimé avec success !');


   }
}
