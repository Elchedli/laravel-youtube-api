<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\InvoicesFilter;
use App\Invoice;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
      /**
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $filter = new InvoicesFilter();
        $queryItems = $filter->transform($request);
        if(count($queryItems) == 0) return new InvoiceCollection(Invoice::paginate());
        else {
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices->appends($request->query()));
        }
    }

    /** 
     * @param \App\Invoice
     * @return \Illuninate\Http\Response
    */
    public function show(Invoice $invoice){
        return new InvoiceResource($invoice);
    }
}
