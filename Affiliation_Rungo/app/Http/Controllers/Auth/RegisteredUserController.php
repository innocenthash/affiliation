<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\LiensUser;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\IdentifiantUser;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Jobs\SendMailWithJobVendeur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Notifications\VendeurEnregistrer;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // http://localhost/Affiliation_Rungo/public/panneau
        $unique=Str::random(10);
        // $liens = new LiensUser() ;
        // $liens->user_id = $user->id ;
        // $liens->url = 'http://localhost/Affiliation_Rungo/public/panneau/'.$unique ;
        // $liens->save();
        // creation de numero unique pour chaque user afin de la lié avec url
        $num = new IdentifiantUser();
        $num->user_id=$user->id;
        $num->identifiant_users= $unique;
        $num->save();


        event(new Registered($user));
        // la notification : envoie mail apres enregistrement
        $user->notify(new VendeurEnregistrer($user));
        SendMailWithJobVendeur::dispatch($user) ;

        Auth::login($user);

        // pour autoriser les vendeurs acceder dans notre site

  return redirect(RouteServiceProvider::HOME);
    }
}
