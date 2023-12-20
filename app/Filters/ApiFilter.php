<?php

namespace App\Filters;

use Illuminate\Http\Request;


class ApiFilter {
    protected $safedParms =[];
    
    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request){
        $eloQuery = [];

        foreach ($this->safedParms as $parm => $operators) {
            $query = $request->query($parm);

            if(!isset($query)){
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if(isset($query[$operator])){
                    $eloQuery[] = [$column, $this->operatorMap[$operator],$query[$operator]];
                }
            }
        }
        return $eloQuery;
    }
}