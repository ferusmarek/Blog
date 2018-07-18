<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        Role::create([
            'id'    =>1,
            'name'  =>'admin',
            'description' => 'can do anything',
        ]);
        Role::create([
            'id'    =>2,
            'name'  =>'moderator',
            'description' => 'can do slighly less things',
        ]);
        Role::create([
            'id'    =>3,
            'name'  =>'user',
            'description' => 'can only do some things',
        ]);
    }

}
