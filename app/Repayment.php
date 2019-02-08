<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ApplyLoan;

class Repayment extends Model
{
     protected $fillable = [
        'applied_loan_id',  'amount', 'txnId', 'description', 'txn_status'
    ];

    public function applyLoan()
    {
        return $this->belongsTo(ApplyLoan::class, 'applied_loan_id');
    }
}
