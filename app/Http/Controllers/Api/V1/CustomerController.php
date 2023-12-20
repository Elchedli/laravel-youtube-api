<?php

namespace App\Http\Controllers\Api\V1;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use App\Filters\V1\CustomersFilter;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $filter = new CustomersFilter();
        $queryItems = $filter->transform($request);

        if(count($queryItems) == 0) return new CustomerCollection(Customer::paginate());
        // else return new CustomerCollection(Customer::where($queryItems)->paginate());
        else {
            $Customers = Customer::where($queryItems)->paginate();
            return new CustomerCollection($Customers->appends($request->query()));
        }
    }

    /** 
     * @param \App\Customer
     * @return \Illuninate\Http\Response
    */
    public function show(Customer $customer){
        return new CustomerResource($customer);
    }
}
