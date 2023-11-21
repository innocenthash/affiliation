<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Product;
use App\Models\LienOffre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LiensController extends Controller
{

 public function create_liens(){
    $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();

$produits = Product::all()->pluck('nom_produit','nom_produit');
return view('backend.create_liens')->with('produits',$produits)->with('messages',$messages);
 }

 public function enregistre_liens(Request $request){
    $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
    // pour acceder au id de produit
    $this->validate($request,['nom_produit'=>'required',
    'titre'=>'required',
    'url'=>'required|unique:lien_offres',
]);
    $produits=Product::where('nom_produit',$request->input('nom_produit'))->get();
    $liens =  new LienOffre();
    $liens->url = $request->input('url');
    $liens->titre = $request->input('titre');


    foreach($produits as $produit) {
        # code...
        $liens->product_id =$produit->id;
    }

    $liens->save();

    return Redirect('/create_liens')->with('status','vous avez ajouter un  lien pour l\'offre '.$request->nom_produit)->with('messages',$messages);


 }

 public function show_liens(){
    $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
    $liens = Product::all();
    // $liens = LienOffre::get();

    return view('backend.show_liens')->with('liens',$liens)->with('messages',$messages);

 }

 public function supprimer_url($id){
    $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
    $liens = LienOffre::find($id);
    $liens->delete();
    return redirect('/manipuler_liens')->with('status','vous avez supprimer un lien !')->with('messages',$messages);
 }

 public function manipuler_liens(){
    $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
    $produis= Product::all();

    return view('backend.manipuler_liens')->with('produis',$produis)->with('messages',$messages);
 }

 public function select_categorie_liens($id){
    $messages = Notice::where('id_receive',Auth::user()->id)->orderBy('created_at','desc')->get();
   // $produis= Product::all();
    // $produis= Product::all();
   $produits= Product::all()->where('id',$id);



   //  $liens = LienOffre::where('product_id',$id);
//    $produits->lien_offres;
    // foreach ( $produits as $liens) {
      # code...
    //   foreach ( $liens->lien_offres as $lien) {
    //     # code...
    //    $lien_unique=$lien->url;
    //    dd($lien_unique);
    //    foreach ($lien_unique as $lien_unique1) {
    //     # code...
    //     dd($lien_unique1);
    //    }


    // dd( $produits->nom_produit);
    // }
    // ->with('produis',$produis)

     return redirect('/manipuler_liens')->with('produits',$produits)->with('messages',$messages);
 }

}
