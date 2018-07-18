<?php

namespace App\Http\Controllers\Auth;
use App\User;
use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
    * Redirect the user to the GitHub authentication page.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirectToProvider($service)
    {

        return Socialite::driver($service)->redirect();
    }

    /**
    * Obtain the user information from GitHub.
    *
    * @return \Illuminate\Http\Response
    */
    public function handleProviderCallback($service)
    {
        $oauth_user = Socialite::driver($service)->user();
        //get user by email or create a new one

		/*

		$client = new \GuzzleHttp\Client([ 'base_uri' => 'https://api.github.com' ]);

		$response = $client->request('GET', '/user/starred', [
			'query' => [
				'access_token' => $oauth_user->token
			]
		]);

		$body = $response->getBody();
		$data = json_decode($body);


		dd( $data );

		*/


        if(!$user = User::whereEmail($oauth_user->email)->first())
        {
            if($oauth_user->nickname==''){
            $user = User::firstOrCreate([
                'name'  =>  $oauth_user->name ,
                'email' =>  $oauth_user->email,
            ]);
        }else {
            $user = User::firstOrCreate([
                'name'  =>  $oauth_user->nickname ,
                'email' =>  $oauth_user->email,
            ]);
        }
        }
        //log the user in
        \Auth::login($user,true);

        //redirect home
        flash('prihlaseny')->success();
        return redirect('/');
        //dd($oauth_user);
        // $user->token;
    }

    public function setLanguage($lang){

        if( array_key_exists( $lang, \Config::get('language') )){
            //\Session::set('applocale', $lang);
            session(['applocale' => $lang]);
        }

        return redirect('/');
    }
}
