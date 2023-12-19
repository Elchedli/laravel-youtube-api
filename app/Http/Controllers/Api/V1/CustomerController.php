<?php

namespace App\Http\Controllers\Api\V1;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return Customer::all();
    }
}
