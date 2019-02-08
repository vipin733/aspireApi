<?php

namespace App\Http\Controllers\Api\Loans;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Loan as LoanResource;
use App\Http\Resources\LoanCollection;
use Validator;
use Auth;
use App\Loan;

class ApiLoansController extends Controller
{
    public function create(Request $r)
    {
     
        $validator = Validator::make($r->all(), [
            'min_amount' => 'required|integer',
            'max_amount' => 'required|integer',
            'month_1' => 'required|numeric',
            'month_2' => 'required|numeric',
            'month_3' => 'required|numeric',
            'month_4' => 'required|numeric',
            'month_5' => 'required|numeric',
            'month_6' => 'required|numeric',
        ]);

        if ($validator->fails()) {
           return response(["errors" => $validator->errors()], 422);
        }

        $data = [
            'min_amount' => $r->min_amount,
            'max_amount' => $r->max_amount,
            'month_1' => $r->month_1,
            'month_2' => $r->month_2,
            'month_3' => $r->month_3,
            'month_4' => $r->month_4,
            'month_5' => $r->month_5,
            'month_6' => $r->month_6,
        ];

        $loan = Loan::create($data);

        return response(['message' => 'Loan Model Created Successfully', "data" => ["loan" => new LoanResource($loan)]], 201);
        

    }

    public function loans()
    {
        $loans = Loan::where('status', true)->get();

        return response(['message' => 'Success', "data" => ["loans" => new LoanCollection($loans)]], 200);
    }

    public function loan($id)
    {
        $loan = Loan::where('status', true)->where('id', $id)->first();

        return response(['message' => 'Success', "data" => ["loan" => new LoanResource($loan)]], 200);
    }
}
