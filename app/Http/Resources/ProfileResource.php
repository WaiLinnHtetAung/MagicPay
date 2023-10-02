<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'amount' => $this->wallet ? number_format($this->wallet->amount) : '',
            'account_number' => $this->wallet ? $this->wallet->account_number : '',
            'profile' => asset('images/profile.png'),
            'qr_value' => $this->phone
        ];
    }
}
