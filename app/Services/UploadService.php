<?php

namespace App\Services;


class UploadService
{
    /**
     * Save file to disk
     *
     * @param $model
     * @param $file
     * @return static
     */
    public function saveFile($model, $file)
    {
        // create new file
        $dirname = strtolower( class_basename($model) ) . 's';

        if ( $dirname === 'users' ) {
            $filepath = public_path("img/$dirname/{$model->id}");
        } else {
            $filepath = storage_path("$dirname/{$model->id}");
        }

        $extension = $file->getClientOriginalExtension();

        $filename  = str_replace(
            ".$extension",
            "-" . rand(11111, 99999) . ".$extension",
            $file->getClientOriginalName()
        );

        // save the file
        $file->move($filepath, $filename);

        // add file to db
        return $this->addFileToDatabase( $file, $filename, $model );
    }


    /**
     * Add file meta-data to DB
     *
     * @param $file
     * @param $filename
     * @param $model
     * @return static
     */
    public function addFileToDatabase($file, $filename, $model )
    {
        // store it in the db
        return \App\File::create([
            'fileable_id'   => $model->id,
            'fileable_type' => get_class($model),
            'name'     => $file->getClientOriginalName(),
            'filename' => $filename,
            'mime'     => $file->getClientMimeType(),
            'ext'      => $file->getClientOriginalExtension(),
            'size'     => 5,
        ]);
    }
}
