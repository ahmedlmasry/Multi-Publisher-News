<?php

namespace Database\Seeders;

use App\Models\Authorization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perms = [
            'posts'           =>' Management Posts',
            'categories'      =>' Management Categories',
            'settings'        =>' Management Settings',
            'users'           =>' Management Users',
            'admins'          =>' Management Admins',
            'contacts'        =>' Management Contacts',
            'home'            =>' Management Home Page',
            'authorizations'  =>' Management Authorizations',
            'profile'         => 'Management Profile',
            'notifications'   => 'Management Notifications',
        ];
       $permissions = [];

        foreach($perms as $permission=>$value){
            $permessions[] = $permission;

        }
        Authorization::create([
            'role'=>'Manager',
            'permissions'=>json_encode($permissions),
        ]);

    }
}
