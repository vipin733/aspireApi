<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'min_amount', 'max_amount', 'month_1', 'month_2', 'month_3', 'month_4', 'month_5', 'month_6', 'processing_fee',  'status', 
    ];
}
