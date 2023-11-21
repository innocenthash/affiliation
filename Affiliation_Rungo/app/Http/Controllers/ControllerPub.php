<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ClicLien;
use App\Models\LienOffre;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\IdentifiantUser;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;


class ControllerPub extends Controller
{

    public function inscription(Request $request ,$id){
// on test si l'id existe

// on recupere juste l'id_unique pourqu'on puisse recuperer le nom du produit (after) et before si c avnt id_unique derniere
        $url = url()->current() ;
        $code = Str::beforeLast($url, '/');
        // dd($code); // zvoDDdiNvP
// $parts = parse_url($url);
// echo $parts['host']; // www.example.com
// echo $parts['path']; // /path
// echo $parts['query']; // foo=bar
// on test si l'id existe
         $product = LienOffre::where('url',$code)->get() ;
foreach ($product as $product_id) {
    # code...
   $prod_id= $product_id->product_id;
};

$produit_du_liens = Product::where('id',$prod_id)->get() ;

foreach ($produit_du_liens as $produit_du_lien) {
    # code...
   $campagnes=$produit_du_lien->nom_produit;

}

        $value = IdentifiantUser::pluck('identifiant_users')->toArray();
        // on verifie si l'id unique existe vraiment
        if (in_array( $id, $value)) {


            // enregistrement pour le clics
            $recup_infos = IdentifiantUser::where('identifiant_users',$id)->get();
            $iduniques = new IdentifiantUser();

            foreach ( $recup_infos as  $recup_info) {
                $recup_info=$recup_info->user_id;
            }
        $clicliens = new ClicLien();
        $clicliens->user_id =$recup_info;
        $clicliens->campagnes = $campagnes ;
        $clicliens->liens = url()->current() ;
        $clicliens->ip = $request->ip() ;
        $clicliens->save();

// $clics = IdentifiantUser::get();
        // $clics = new IdentifiantUser();
        // pour tester si la valeur url existe deja dans le db
        $values = IdentifiantUser::pluck('url')->toArray();

        $ip = IdentifiantUser::pluck('ip')->toArray();


        // dd($values);
        $url=url()->current() ;
        if (in_array( $url, $values)) {

            $recup_infos = IdentifiantUser::where('identifiant_users',$id)->get();
            foreach ( $recup_infos as  $recup_info) {
                $recup_info= $recup_info->user_id ;
        }

        $lien_existe = IdentifiantUser::where('user_id',$recup_info)->increment('status');
// dd("edee");

        } else {

            echo 'ip n\'est pas trouvé';
            $recup_infos = IdentifiantUser::where('identifiant_users',$id)->get();
            $iduniques = new IdentifiantUser();

            foreach ( $recup_infos as  $recup_info) {
                $iduniques->user_id=$recup_info->user_id;
                $iduniques->identifiant_users = $id;
                $iduniques->url=$request->url();
                $iduniques->ip=$request->ip() ;
                $iduniques->save();



        }


    }

        } else {
echo 'dsdfbz';
        }

        return view('mes_offres.inscription');



    //     $url=url()->current();
    //     foreach ( $clics as  $clic) {
    //         $liens= IdentifiantUser::where('url',$url)->get();
    //         if(isset($clic->url==$url)){
    //             $lien_existe = IdentifiantUser::where('url',$url)->increment('status');
    //             dd("eeeeee");
    //            break ;

    //         }else{


            //     $recup_infos = IdentifiantUser::where('identifiant_users',$id)->get();
            //     $iduniques = new IdentifiantUser();

            //     foreach ( $recup_infos as  $recup_info) {
            //         $iduniques->user_id=$recup_info->user_id;
            //         $iduniques->identifiant_users = $id;
            //         $iduniques->url=$request->url();
            //         $iduniques->save();

            //   return view('mes_offres.inscription');

    //         }



    //     }
    // }


    }
        // url()->current().'?'.http_build_query(Request::except($id));

    //    $url=url()->current().'?'.http_build_query($request->except($id));

    //     $url = url()->current();
    //     // $url = url()->full();
    //     $url = url()->to('/')->with();
    //     $url = url()->to('/');
    //    dd($url);

    // $id_users =  IdentifiantUser::where('identifiant_users',$id)->get();
    // $my_user = '';
    // foreach ( $id_users as  $id_user) {
    //     # code...
    //     $my_user =$id_user->user_id;
    // }

    // dd($my_user);

    // $new_url = new IdentifiantUser();
    // $new_url->identifiant_users = $id ;
    // $new_url->user_id = $my_user ;
    // $new_url->identifiant_users = $id ;

    // for($i=0;$i<100;$i++){
    //     $id->status= $cookie_value;
    // //
    //      $id->url=$request->url();
    // $id->update();
        // $lien_offres= LienOffre::where('url',$url)->get();
        //  dd($lien_offres);

        // foreach($lien_offres as $lien_offre) {
        //    dd($lien_offre->url);
        // }

        // dd('yyy');

        // $tab = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
        // shuffle($tab);
        // sort($tab);




        // $iduni = IdentifiantUser::where('identifiant_users',$id);
        // $iduni

        // $iduni->update();

        // $iduniques = IdentifiantUser::where('identifiant_users',$id)->orderBy('identifiant_users','asc')->get();  test avec id unique
//         $url=url()->current();
//         // test avec l'url
//         $iduniques = IdentifiantUser::where('identifiant_users',$id)->orderBy('url','desc')->get();
// // on le met a jour pour savoir le nombre de clic
// // on verifie d'abord si l'id:nombre unique en question existe dans db

// // si l\'email existe deja on met a jour si non on cree
// foreach ( $iduniques as  $idunique) {

//     if($idunique->identifiant_users==$id){
//         $url=url()->current();
//         if($idunique->url==$url){
//                    // $i=0 ;
//         // if(isset($id)){
//             // dd($idunique->updated_at);

//             Session::put('date',$idunique->updated_at);

//             //             $date1=Carbon::createFromFormat('m/d/Y H:i:s',Auth::user()->identifiantuser->updated_at);

//             // $date=Carbon::createFromFormat('m/d/Y H:i:s',Session::get('date'));

//             // $r=$date1->eq($date);

//             // dd($r);

//                         // $i=rand(1,5);
//                         // $p=0;
//                         // $p++;

//                         // $valeur_actuelle = Cookie::make('nom',1,300);
//                         //   $valeur_actuelle= Cookie::get('nom');
//                         // $valeur_actuelle++;
//                         // cookie('nom', $valeur_actuelle);
//             //  return response('Contenu de la réponse')->cookie('nom', $value);

//             // Session::put('nomVariable', 0);

//             // Session::get('nomVariable');


//             // setcookie('erreur',"", time() - 3600, '/');

//             if(isset($_COOKIE['new'])) {
//                 $cookie_value = $_COOKIE['new'];
//                 $cookie_value++;
//                 setcookie('new', $cookie_value, time() + (60*60*24*365), "/");
//             } else {
//                 $cookie_value = 1;
//                 setcookie('new', $cookie_value, time() +  (60*60*24*365), "/");
//             }

//             // $valeur_actuelle = session('valeur_actuelle', 0);

//             // $valeur_actuelle++;
//             // session(['valeur_actuelle' => $valeur_actuelle]);

//             // $request->session()->put($valeur_actuelle, $valeur_actuelle);

//             // liens offres teste


//                     // }
//                     $id = IdentifiantUser::find($idunique->id);
//                     // for($i=0;$i<100;$i++){
//                         $id->status= $cookie_value;
//                     //  }
//                     $id->url=$request->url();
//                     $id->update();
//                  return view('mes_offres.inscription');
//         }else{

//             if(isset($_COOKIE['new'])) {
//                 $cookie_value = $_COOKIE['new'];
//                 $cookie_value++;
//                 setcookie('new', $cookie_value, time() + (60*60*24*365), "/");
//             } else {
//                 $cookie_value = 0;
//                 setcookie('new', $cookie_value, time() +  (60*60*24*365), "/");
//             }

//             // $valeur_actuelle = session('valeur_actuelle', 0);

//             // $valeur_actuelle++;
//             // session(['valeur_actuelle' => $valeur_actuelle]);

//             // $request->session()->put($valeur_actuelle, $valeur_actuelle);

//             // liens offres teste


//                     // }
//                     $i = new IdentifiantUser();
//                     // for($i=0;$i<100;$i++){
//                         $i->status= $cookie_value;
//                     //  }
//                     $i->user_id=$idunique->user_id;
//                     $i->identifiant_users = $id;
//                     $i->url=$request->url();
//                     $i->save();
//                   return view('mes_offres.inscription');

//             dd('merci c\'est ok');
//         }

//     //

//     }else{
//         dd('ddd');
//     }
//         }
    // }

    public function inscriptions(Request $request ,$id){

// onn selection une colonne specifique dans le db et transformer lrs valeurs en tableau
        $values = IdentifiantUser::pluck('url')->toArray();
        // dd($values);
        $url=url()->current() ;
        if (in_array( $url, $values)) {
            $lien_existe = IdentifiantUser::where('url',$url)->increment('status');
        } else {
            $recup_infos = IdentifiantUser::where('identifiant_users',$id)->get();
            $iduniques = new IdentifiantUser();

            foreach ( $recup_infos as  $recup_info) {
                $iduniques->user_id=$recup_info->user_id;
                $iduniques->identifiant_users = $id;
                $iduniques->url=$request->url();
                $iduniques->save();

          return view('mes_offres.inscription');

        }

}
    }

//         $iduniques = IdentifiantUser::where('identifiant_users',$id)->orderBy('url','desc')->get();

// foreach ( $iduniques as  $idunique) {

// if($idunique->identifiant_users==$id){

//     if($idunique->url==url()->current()){
//         // dd($iduniques);
//             Session::put('date',$idunique->updated_at);

// if(isset($_COOKIE['news'])) {
//     $cookie_value = $_COOKIE['news'];
//     $cookie_value++;
//     setcookie('news', $cookie_value, time() + (60*60*24*365), "/");
// } else {
//     $cookie_value = 1;
//     setcookie('news', $cookie_value, time() + (60*60*24*365), "/");
// }

//         $id = IdentifiantUser::find($idunique->id);

//             $id->status= $cookie_value;

//         $id->url=$request->url();
//         $id->update();
//      return view('mes_offres.inscription');
//     }else{

//         if(isset($_COOKIE['news'])) {
//             $cookie_value = $_COOKIE['news'];
//             $cookie_value++;
//             setcookie('news', $cookie_value, time() + (60*60*24*365), "/");
//         } else {
//             $cookie_value = 0;
//             setcookie('news', $cookie_value, time() +  (60*60*24*365), "/");
//         }


//                 $i = new IdentifiantUser();
//                 $i->user_id=$idunique->user_id;
//                     $i->status= $cookie_value;
//                     $i->identifiant_users = $id;
//                 $i->url=$request->url();
//                 $i->save();
//               return view('mes_offres.inscription');

//         dd('merci c\'est ok');
//     }

// }else{
//     dd('dbdns');
// }


           }


