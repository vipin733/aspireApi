<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RepaymentCollection;

class ApplyLoan extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $url = url("/"). "/api/my/apply/loan/". $this->id;
        $isClosed = $this->isClosed ? true : false;
        $interest         = $this->interest;   
        $tenur            = $this->tenur;
        $amount           = $this->amount;
        $total_due_amount = $this->due_amount;
        $processing_fee   = 0;

        if ($total_due_amount > $amount) {
            $processing_fee = $this->processing_fee;
        }
        $rate             = $interest /100  / 12;
        // calculating emi
        $emi              = $amount * $rate * (pow(1 + $rate, $tenur) / (pow(1 + $rate, $tenur) - 1));
        $next_due_amount  = ceil($emi + $processing_fee);

        
        return [
            'amount'           => $amount,
            'tenur'            => $tenur,
            'pan_card'         => $this->pan_card,
            'interest_rate'    => $this->interest,
            'next_due_date'    => $this->when(!$isClosed , $this->due_date),
            'total_due_amount' => $this->when(!$isClosed , $this->due_amount),
            'next_due_amount'  => $this->when(!$isClosed , $next_due_amount),
            'isClosed'         => $this->isClosed ? true : false,
            'created_at'       => $this->created_at,
            'repayments'       => $this->when($this->isRepayments, new RepaymentCollection($this->repayments)),
            'link'             => $url
        ];
    }
}
