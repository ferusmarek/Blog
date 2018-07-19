<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //policka ktore nemozu byt vyplnetelne
    protected $guarded = ['id'];

    public function post()
	{
		return $this->belongsTo('App\Post');
	}


	public static function saveFile( $post, $file )
	{
		// create new file
		$filepath  = storage_path('posts/' . $post->id);
		$extension = $file->getClientOriginalExtension();
		$filename = str_replace(
			".$extension",
			"-". rand(11111, 99999) . ".$extension",
			$file->getClientOriginalName()
		);

		// save the file
		$file->move($filepath, $filename);

		// store it in the DB
		return File::create([
			'post_id'  => $post->id,
			'name'     => $file->getClientOriginalName(),
			'filename' => $filename,
			'mime'     => $file->getClientMimeType(),
			'ext'      => $extension,
			'size'     => 5,
		]);
	}
}
