<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Services\UploadService;
use Image;


class UserController extends Controller
{
    protected $upload;

    public function __construct(UploadService $upload)
    {
        $this->upload = $upload;
    }
    public function show($name)
    {
        $user1 = urldecode($name);
        $user = User::whereName($user1)
            ->firstOrFail();

        return view('post.index')
        ->with('title', $user->email)
        ->with('posts', $user->posts);
    }

    public function edit($name)
	{
        $user1 = urldecode($name);
        $user = User::whereName($user1)
            ->firstOrFail();


		// only owner can do this
		$this->authorize('is-user', $user);

		return view('auth.edit', [
			'title' => 'Edit user',
			'user'  => $user,
		]);
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


    	/**
    	 * @param Request $request
    	 * @param $id
    	 * @return $this|\Illuminate\Http\RedirectResponse
    	 */
    	public function update(Request $request, $id)
    	{
    		// grab the user
    		$user = User::findOrFail($id);

    		// only owner can do this
    		$this->authorize('is-user', $user);

    		// validate form
    		$validator = $this->validator( $request->all() );
    		if ( $validator->fails() ) {
    			return back()->withErrors($validator)->withInput();
    		}

    		// update user
    		$this->updateUser( $user, $request );

    		// go home
    		flash()->success('updated!');
    		return redirect()->route('user.edit', $user->name);
    	}


    	/**
    	 * @param $user
    	 * @param $request
    	 */
    	private function updateUser($user, Request $request)
    	{
    		// update user
    		$user->name = $request->get('name');

    		// change password only if one was entered
    		if ( $request->get('password') ) {
    			$user->password = bcrypt( $request->get('password') );
    		}

    		// handle image upload
    		$this->uploadImage( $user, $request) ;

    		return $user->save();
    	}


    	/**
    	 * Get a validator for an incoming user update request.
    	 *
    	 * @param  array  $data
    	 * @return \Illuminate\Contracts\Validation\Validator
    	 */
    	private function validator(array $data)
    	{
    		return \Validator::make($data, [
    			'name' => 'required|max:255',
    			'password' => 'confirmed|min:6',
    			'avatar' => 'image'
    		]);
    	}


    	/**
    	 * Upload image & create thumbs
    	 *
    	 * @param $user
    	 * @param $request
    	 * @return bool|void
    	 */
    	private function uploadImage($user, $request)
    	{
    		if ( !$request->file('avatar') || !$request->file('avatar')->isValid() ) return;

    		// save new image file
    		$file = $this->upload->saveFile($user, $request->file('avatar'));

    		$path = public_path('img/users/'.$user->id.'/');
    		$filepath = $path.$file->filename;
    		$filename = basename( $file->name, '.'.$file->ext );

    		// grab the big image
    		$img = Image::make( $filepath );

    		// thumbnail
    		$img->resize(250, null, function ($constraint){
    			$constraint->aspectRatio();
    		})->save( // thumbnail
    			$path . $filename . '-thumb.' . $file->ext
    		)->crop(80, 80)->save( // tiny
    			$path . $filename . '-tiny.' . $file->ext
    		);

    		// grab the big one again
    		$img = Image::make( $filepath );

    		// make crop
    		$img->crop(250, 250)->save(
    			$path . $filename . '-crop.' . $file->ext
    		);

    		return true;
    	}
}
