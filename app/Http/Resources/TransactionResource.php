<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'trx_id' => $this->trx_id,
            'amount' => number_format($this->amount, 2). " MMK",
            'type' => $this->type == 1 ? 'income' : 'expense',
            'title' => $this->type == 1 ? "From ". $this->source->name : "To ".$this->source->name,
            'description' => $this->description ?? '',
            'date' => date_format($this->created_at, 'd-m-Y'),
        ];
    }
}
