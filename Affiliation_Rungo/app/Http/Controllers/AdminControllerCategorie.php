<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminControllerCategorie extends Controller
{
    //
    public function formulaire_categorie(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('backend.formulaire_categorie')->with('messages',$messages);
    }

    public function enregistrer_categorie(Request $request){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $this->validate($request,['categorie_nom'=>'required']);
        $categorie = new Categorie() ;

        $categorie->nom_categorie = $request->input('categorie_nom') ;

        $categorie->save() ;

        return back()->with('status','Categorie crée avec succès !')->with('messages',$messages);
    }
    public function affiche_categorie(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $categories=Categorie::get() ;

        return view('backend.affiche_categorie')->with('categories',$categories)->with('messages',$messages) ;
    }

    public function supprimer_categorie($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $categorie = Categorie::find($id) ;
        $categorie->delete() ;

        return back()->with('status', 'categorie supprimé avec succès !')->with('messages',$messages) ;
    }

    public function editer_categorie($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $categories= Categorie::find($id);
        return view('backend.editer_categorie')->with('categories',$categories)->with('messages',$messages);
    }

    public function modifier_categorie($id , Request $request){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $categories= Categorie::find($id);
        $categories->nom_categorie = $request->input('categorie_nom') ;
        $categories->update() ;
        // $categories=Categorie::get() ;
        return redirect('affiche_categorie')->with('status_m','Categorie modifié avec succès !')->with('messages',$messages);
    }
}
