<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function posts(){

        return $this->hasMany('App\Post')->latest('created_at');

    }
    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function file()
    {
        return $this->morphOne('App\File', 'fileable')->latest('created_at');
    }

    public function getAvatarAttribute()
    {
        if ( ! $this->file ) return false;

        return [
            'full'  => $this->avatarSize(),
            'crop'  => $this->avatarSize('crop'),
            'thumb' => $this->avatarSize('thumb'),
            'tiny'  => $this->avatarSize('tiny'),
        ];
    }


    private function avatarSize($size = null)
    {
        $file = $this->file;

        $path = asset('img/users/'.$file->fileable_id);
        $filename = $file->filename;

        if ( $size ) {
            $filename = basename( $file->name, '.'.$file->ext ) . '-' . $size . '.' . $file->ext;
        }

        return asset( $path.'/'.$filename );
    }

    public function hasRole($role){
        $role_check = $this->roles->toArray();
        foreach($role_check as $roles){
            return $roles['name'] == $role;    }
            }



}
