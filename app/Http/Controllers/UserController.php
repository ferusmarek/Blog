<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Socialite;

class UserController extends Controller
{
    public function show($name)
    {
        $user1 = urldecode($name);
        $user = User::whereName($user1)
            ->firstOrFail();

        return view('post.index')
        ->with('title', $user->email)
        ->with('posts', $user->posts);
    }

    /**
    * Redirect the user to the GitHub authentication page.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirectToProvider()
    {
        return Socialite::driver('instagram')->redirect();

    }

    /**
    * Obtain the user information from GitHub.
    *
    * @return \Illuminate\Http\Response
    */
    public function handleProviderCallback()
    {
        $oauth_user = Socialite::driver('instagram')->user();
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


		dd( $data );*/



        $user = User::whereName($oauth_user->name)->firstOrFail();

            $client = new \GuzzleHttp\Client([ 'base_uri' => 'https://api.instagram.com/v1' ]);

    		$response = $client->request('GET', '/users/self/media/recent/', [
    			'query' => [
    				'access_token' => $oauth_user->token,
    			]
    		]);
            $body = $response->getBody();
            $data = json_decode($body);

            return view('post.index')
                    ->with('data', $data);

    }
}
