<?php

namespace App\Http\Controllers;
use App\Post;
use App\User;
use App\Tag;
use App\File;
use App\Services\UploadService;

use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Excel;


class PostController extends Controller
{
    protected $upload;

    public function __construct(UploadService $upload)
    {
        $this->upload = $upload;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = \Cache::rememberForever('all-posts',function(){
            return Post::latest('created_at','desc')->get();
        });
        return view('post.index')
            ->with('posts', $posts);

    }
    public function export()
    {
        //DB::setFetchMode(PDO::FETCH_ASSOC);
        $data = Post::get()->toArray();
              return Excel::download('out', function($excel) use ($data) {
                  $excel->sheet('posts', function($sheet) use ($data)
                  {
                      $sheet->fromArray($data);
                  });
              })->download('xls');



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('post.create')
        ->with('title', 'Add post')
        ->with('tags', $tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\SavePostRequest $request)
    {
        $post= Auth::user()->posts()->create($request->all());

        $post->tags()->sync( $request->get('tags')?:[]);

        // upload files
		$this->uploadFiles($post, $request->file('items'));

        // success message
        flash('hotovo')->success();

        // redirect to post
        return redirect()->route('post.show', $post->slug);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post= Post::whereSlug($slug)
                    ->firstOrFail();

        return view('post.show')
        ->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $tags = Tag::all();

        // only owner can see the edit for
        $this->authorize('edit-post', $post);
        return view('post.edit')
        ->with('title', 'Edit post')
        ->with('post', $post)
        ->with('tags', $tags);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\SavePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        // update post
      $this->authorize('edit-post', $post);
        $post->update( $request->all() );
        // attach tags
        $post->tags()->sync( $request->get('tags')?:[]);

        $this->uploadFiles($post, $request->file('items'));



        // redirect to post
        flash('Post updated!')->success();
        return redirect()->route('post.show', $post->slug);
    }

    /**
     * Show the form for removing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        // only owner can see the edit for
        $this->authorize('edit-post', $post);

        return view('post.delete')
        ->with('title', 'Delete post')
        ->with('post', $post);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //jeden sposob
        //Auth::user()->posts()->findOrFail($id)->delete();

        $post = Post::findOrFail($id);
        // if authorized, delete
      $this->authorize('edit-post', $post);
        $post->delete();

        // remove files
       \File::deleteDirectory( storage_path('posts/' . $post->id) );

        // redirect home
        flash('Vymazané!')->success();
        return redirect('/');
    }


	private function uploadFiles($post, $files)
	{
		if ( $files ) foreach ($files as $file)
		{
			if ( !$file || !$file->isValid() ) continue;
            //saveFile sa spusti po uplade, v uploadservice
            $this->upload->saveFile($post, $file);
        }
	}
}
