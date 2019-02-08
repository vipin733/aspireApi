<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// authentication
Route::post('/register', 'Api\Auth\ApiRegistrationController@register');
Route::post('/login', 'Api\Auth\ApiLoginController@login');

//loans
Route::middleware('auth:api')->post('/loan/create', 'Api\Loans\ApiLoansController@create');
Route::middleware('auth:api')->get('/loans', 'Api\Loans\ApiLoansController@loans');
Route::get('/loan/{id}', 'Api\Loans\ApiLoansController@loan');

//apply loans
Route::middleware('auth:api')->post('/apply/loan', 'Api\Apply\ApiApplyLoanController@apply_loan');

Route::middleware('auth:api')->get('/my/apply/loans', 'Api\Apply\ApiApplyLoanController@myAppliedLoans');
Route::middleware('auth:api')->get('/my/apply/loan/{id}', 'Api\Apply\ApiApplyLoanController@myAppliedLoan');


// repayment
Route::middleware('auth:api')->post('/repayment/loan/{id}', 'Api\Repayment\ApiRepaymentController@repayment_loan');

Route::middleware('auth:api')->get('/my/repayments', 'Api\Repayment\ApiRepaymentController@my_repayments');
Route::middleware('auth:api')->get('/my/repayment/{id}', 'Api\Repayment\ApiRepaymentController@my_repayment');

