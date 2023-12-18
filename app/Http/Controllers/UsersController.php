<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    function getUsers(){
        $name = 'Mohamed';
        //Method 1
        // $age = 18;
        // return view('Users',compact('name','age'));
        // Method 2
        //problem with this method : can only pass one variable
        // return view('Users')->with('name',$name); 
        // so as a solution 
        $users = [
            'user1' => 'Mohamed',
            'user2' => 'Aziz',
            'user3' => 'rabi',
            'user4' => 'mohamed',
        ];
        return view('Users')->with('users',$users);
    }
}
