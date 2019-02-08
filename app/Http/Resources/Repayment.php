<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Repayment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $url = url("/"). "/api/my/repayment/". $this->id;
        return [
            'amount'           => $this->amount,
            'txnId'            => $this->txnId,
            'description'      => $this->description,
            'txn_status'       => $this->txn_status ? true : false,
            'link'             => $url
        ];
    }
}
