<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        // auth is an instance of authentication system
        // user returns the User model, meaning u can access all properties and methods
        // isAdmin() is a method that u access cause u can :D
        if (!auth()->user()->isAdmin()){
            abort(403, 'Unauthorized');
            //forbidden
        }

        return view ('admin.dashboard');
    }
}
