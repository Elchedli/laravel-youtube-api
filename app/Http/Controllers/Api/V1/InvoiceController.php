<?php

namespace App\Http\Controllers\Api\V1;


use App\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;


class InvoiceController extends Controller
{
      /**
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return new InvoiceCollection(Invoice::paginate());
    }

    /** 
     * @param \App\Invoice
     * @return \Illuninate\Http\Response
    */
    public function show(Invoice $invoice){
        return new InvoiceResource($invoice);
    }
}
