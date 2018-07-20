<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\File;

class FileController extends Controller
{
    public function download($id, $name)
    {
        $file = \App\File::findOrFail($id);

        return response()->download(
            storage_path("posts/{$file->fileable_id}/{$file->filename}")
        );
    }

    public function getIconAttribute() {

        $extensions = [
            'txt' => 'txt.png',
            'pdf' => 'pdf.png',
            'xls' => 'xls.png',
            'csv' => 'csv.png',
            'doc' => 'doc.png',
        ];

        return array_get($extensions,$this->extension,'unknown.png');
    }

    public function removeFile( $id, $name, $fileid) {

		$file = File::findOrFail( $fileid );

		$file->delete();

		\File::delete( storage_path('posts/' . $id . '/'. $name) );

		flash()->success("File removed!");
		return back();
	}

    	/**
    	 * @param $id
    	 *
    	 * @return \Illuminate\Http\RedirectResponse
    	 */
    	public function removeCover( $id, $name) {

    		$cover = Post::findOrFail( $id );

    		$cover->update(['cover' => 'NULL']);

    		\File::delete( public_path('coverimg/posts/'.$id.'/'.$name) );

    		flash()->success("File removed!");
    		return back();
    	}
}
