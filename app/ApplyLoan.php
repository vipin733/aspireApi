<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Repayment;

class ApplyLoan extends Model
{
    protected $fillable = [
        'user_id', 'processing_fee', 'amount', 'interest', 'tenur', 'pan_card', 'due_amount', 'due_date', 'isClosed'
    ];
    
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function repayments()
    {
        return $this->hasMany(Repayment::class, 'applied_loan_id');
    }
    
}
