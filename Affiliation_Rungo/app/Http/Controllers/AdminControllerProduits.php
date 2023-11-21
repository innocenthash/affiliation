<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Product;
use App\Models\Categorie;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class AdminControllerProduits extends Controller
{
    public function index(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('racine_backend.index')->with('messages',$messages);
    }

    public function formulaire_produits(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $categories = Categorie::all()->pluck('nom_categorie','nom_categorie');
        return view('backend.formulaire_produits')->with('categories',$categories)->with('messages',$messages);
    }

    public function enregistrer_produit(Request $request){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
$this->validate($request,[
    'nom_produit'=>'required',
'nom_categorie'=>'required',
   'commission'=>'required',
'image_produit'=>'image|nullable|max:2000',
   'description_produit'=>'required'
]) ;

if($request->hasFile('image_produit')){
    $nom_du_fichier_avec_ext = $request->file('image_produit')->getClientOriginalName();

    $nom_du_fichier = pathinfo($nom_du_fichier_avec_ext,PATHINFO_FILENAME) ;

    $ext = $request->file('image_produit')->getClientOriginalExtension();

    $nom_du_fichier_save = $nom_du_fichier.'_'.time().'.'.$ext ;

    $chemin = $request->file('image_produit')->storeAs("public/images_produits",$nom_du_fichier_save) ;

}else{
    $nom_du_fichier_save = 'pas_image.jpg' ;
}

        $produit = new Product() ;

        $produit->nom_produit = $request->input('nom_produit');
        $produit->nom_categorie = $request->input('nom_categorie');
        $produit->commission= $request->input('commission');
        $produit->prix= $request->input('prix');
        $produit->image_produit= $nom_du_fichier_save;
        $produit->description_produit= $request->input('description_produit');
        $produit->status= 0 ;
        $produit->save() ;

        return back()->with('status','Votre produit a été crée avec succès !')->with('messages',$messages) ;

    }

    public function affichage_produit(){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
            $produits = Product::orderBy('created_at','desc')->get();
        return view('backend.affiche_produit')->with('produits',$produits)->with('messages',$messages);
    }
    public function edit_produit($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $produits = Product::find($id) ;
        $categories = Categorie::all()->pluck('nom_categorie','nom_categorie') ;
        return view('backend.edit_produit')->with('produits',$produits)->with('categories',$categories)->with('messages',$messages);
    }
    public function modifier_produit($id , Request $request){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $this->validate($request,[
            'nom_produit'=>'required',
        'nom_categorie'=>'required',
           'commission'=>'required',
        'image_produit'=>'image|nullable|max:2000',
           'description_produit'=>'required'
        ]) ;

        $produit = Product::find($id) ;

        $produit->nom_produit = $request->input('nom_produit');
        $produit->nom_categorie = $request->input('nom_categorie');
        $produit->commission= $request->input('commission');
        $produit->prix= $request->input('prix');

        $produit->description_produit= $request->input('description_produit');
        $produit->status= 0 ;

 if($request->hasFile('image_produit')){


        $nom_du_fichier_avec_ext = $request->file('image_produit')->getClientOriginalName();

        $nom_du_fichier = pathinfo($nom_du_fichier_avec_ext,PATHINFO_FILENAME) ;

        $ext = $request->file('image_produit')->getClientOriginalExtension();

        $nom_du_fichier_save = $nom_du_fichier.'_'.time().'.'.$ext ;

        if($produit->image_produit!='pas_image.jpg'){
            Storage::delete('public/images_produits/'.$produit->image_produit);
        }

        $chemin = $request->file('image_produit')->storeAs("public/images_produits",$nom_du_fichier_save) ;
 }else{
    $nom_du_fichier_save = 'pas_image.jpg' ;
}

        $produit->image_produit= $nom_du_fichier_save;
        $produit->update() ;

        return redirect('/affichage_produits')->with('status','Votre produit a été modifié avec succès !')->with('messages',$messages) ;

    }

    public function supprimer_produit($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
         $produit=Product::find($id) ;
         if($produit->image_produit!='pas_image.jpg'){
            Storage::delete('public/images_produits/'.$produit->image_produit);
        }
        $produit->delete();
        return back()->with('messages',$messages);
    }

    public function activer_produit($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $produit=Product::find($id) ;
        $produit->status = 1 ;
        $produit->update() ;
        return redirect('/affichage_produits')->with('status','Le produit '.$produit->nom_produit.' a été activé avec success ')->with('messages',$messages);
    }
    public function desactiver_produit($id){
        $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
        $produit=Product::find($id) ;
        $produit->status = 0 ;
        $produit->update() ;
        return redirect('/affichage_produits')->with('status_d','Le produit '.$produit->nom_produit.' a été desactivé avec success ')->with('messages',$messages);
    }
}
