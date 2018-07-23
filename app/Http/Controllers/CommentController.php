<?php

namespace App\Http\Controllers;
use App\Comment;
use App\Post;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ...  validation
        if ( ! $request->get('text') )
        {
            if ( $request->ajax() ) {
                return response()->json([
                    'error' => 'no text'
                ]);
            }

            return back()->withErrors([ 'text' => ' write something' ]);
        }

        $post = Post::findOrFail( $request->get('post_id') );

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => \Auth::id(),
            'text'    => $request->get('text')
        ]);

        if ( $request->ajax() )
        {
            return response()->json([
                'id' => $comment->id,
                'message' => 'all was well',
            ], 200);
        }

        flash()->success("you commented!");
        return redirect()->route('post.show', $post->slug);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $comment = Comment::findOrFail($id);

        return view('partials.comment')
            ->with('comment', $comment);
    }
}
