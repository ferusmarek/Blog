<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = ['name','description'];

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
