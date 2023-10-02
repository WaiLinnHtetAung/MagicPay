<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
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
            'ref_no' => $this->ref_no,
            'amount' => number_format($this->amount, 2). " MMK",
            'type' => $this->type == 1 ? 'income' : 'expense',
            'to_from' => $this->type == 1 ? "From" : "To",
            'to_from_person' => $this->source->name,
            'description' => $this->description ?? '',
            'date' => date_format($this->created_at, 'd-m-Y')
        ];
    }
}
