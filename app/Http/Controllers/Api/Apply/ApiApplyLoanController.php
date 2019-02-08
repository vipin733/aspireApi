<?php

namespace App\Http\Controllers\Api\Apply;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplyLoan as ApplyLoanResource;
use App\Http\Resources\ApplyLoanCollection;

use Validator;
use App\ApplyLoan;
use App\Loan;
use Carbon\Carbon;

class ApiApplyLoanController extends Controller
{
    public function apply_loan(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'amount'   => 'required|min:4,integer',
            'tenur'    => 'required|integer',
            'pan_card' => 'required'
        ]);

        if ($validator->fails()) {
           return response(["errors" => $validator->errors()], 422);
        }

        $amount = $r->amount;
        $tenur = $r->tenur ;
        // taking one time processing fee by default but we can make dynamic 
        $processing_fee = 500;

        $loan = Loan::where('min_amount',  '<=', $amount)->where('max_amount', ">=", $amount)->first();
        
        if (!$loan) {
            return response(['message' => 'Faild', "data" => []], 400);
        }

        $month = "month_$tenur";
        $interest = $loan[$month];

        $data = [
            'processing_fee' => 500,
            'amount'         => $amount,
            'tenur'          => $r->tenur,
            'pan_card'       => $r->pan_card,
            'interest'       => $interest,
            "due_date"       => Carbon::now()->addMonths(1),
            'due_amount'     => $amount + $processing_fee
        ];

        $applied_loan = auth()->user()->appliedLoans()->create($data);
        
        return response(['message' => 'Loan Applied Successfully', "data" => ["applied_loan" => new ApplyLoanResource($applied_loan)]], 201);
    }


    public function myAppliedLoans()
    {
        $appliedLoans = ApplyLoan::where('user_id', auth()->id())->get();

        return response(['message' => 'Success', "data" => ["applied_loans" => new ApplyLoanCollection($appliedLoans)]], 200);
    }

    public function myAppliedLoan($id)
    {
        $appliedLoan = ApplyLoan::where('user_id', auth()->id())->where('id', $id)->with('repayments')->first();
        
        $appliedLoan['isRepayments'] = true;


        return response(['message' => 'Success', "data" => ["applied_loan" => new ApplyLoanResource($appliedLoan)]], 200);
    }
}
