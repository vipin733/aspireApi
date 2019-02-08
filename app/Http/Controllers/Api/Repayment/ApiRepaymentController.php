<?php

namespace App\Http\Controllers\Api\Repayment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Repayment as RepaymentResource;
use App\Http\Resources\RepaymentCollection;

use App\ApplyLoan;
use App\Repayment;
use Validator;
use Carbon\Carbon;

class ApiRepaymentController extends Controller
{
    public function repayment_loan($id, Request $r)
    {
        $validator = Validator::make($r->all(), [
            'amount' => 'required|integer',
        ]);

        if ($validator->fails()) {
           return response(["errors" => $validator->errors()], 422);
        }

        $appliedLoan = ApplyLoan::where('id', $id)->where('user_id', auth()->id())->where('isClosed', false)->first();

        if (!$appliedLoan) {
            return response(['message' => 'Already paid due amount', "data" => []], 400);
        }

        $data = [
          'amount' => $r->amount,
          'txnId'  => mt_rand(100000,1000000),
          'txn_status' => true
        ];

        $repayment = $appliedLoan->repayments()->create($data);  // creating repayment

        $total_due_amount = $appliedLoan->due_amount - $r->amount;
        $due_date   =  Carbon::parse($appliedLoan->due_date)->addMonths(1);

        $isClosed = $total_due_amount <= 0 ? true : false;

        $data = [
            "due_date"       => $due_date,
            'due_amount'     => $total_due_amount,
            'isClosed'       => $isClosed
        ];

        $appliedLoan->update($data);  // updating apllied loan

        return response(['message' => 'Repayment Created Successfully', "data" => ['repayment' => new RepaymentResource($repayment)]], 400);
    }

    public function my_repayments()
    {
        $repayments = Repayment::whereHas('applyLoan', function($q) {
                                        $q->where('user_id', auth()->id());
                                })->get();

        return response(['message' => 'Success', "data" => ["repayments" => new RepaymentCollection($repayments)]], 200);

    }

    public function my_repayment($id)
    {
        $repayment = Repayment::where('id', $id)->whereHas('applyLoan', function($q) {
                                        $q->where('user_id', auth()->id());
                                })->first();

        return response(['message' => 'Success', "data" => ["repayment" => new RepaymentResource($repayment)]], 200);

    }
}
