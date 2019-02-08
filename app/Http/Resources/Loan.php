<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Loan extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $url = url("/"). "/api/loan/". $this->id;
        return [
            'min_amount' => $this->min_amount,
            'max_amount' => $this->max_amount,
            'month_1'    => $this->month_1,
            'month_2'    => $this->month_2,
            'month_3'    => $this->month_3,
            'month_4'    => $this->month_4,
            'month_5'    => $this->month_5,
            'month_6'    => $this->month_6,
            'isActive'   => $this->status ? true : false,
            'created_at' => $this->created_at,
            'link'       => $url
        ];
    }
}
