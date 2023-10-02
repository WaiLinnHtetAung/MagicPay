<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionDetailResource;

class PageController extends Controller
{
    public function profile() {
        $user = auth()->user()->load('wallet');

        $data = new ProfileResource($user);

        return success('user porfile', $data);
    }

    public function transaction(Request $request) {
        $transactions = Transaction::with(['user', 'source'])->orderBy('created_at', 'desc')->where('user_id', auth()->user()->id);

        if($request->type) {
            $transactions = $transactions->whereType($request->type);
        }

        if($request->date) {
            //check with only date not time
            $transactions = $transactions->whereDate('created_at', $request->date);
        }

        $transactions = $transactions->paginate(5);


        $data = TransactionResource::collection($transactions)->additional(['result' => 1, 'message' => 'transaction success']);

        return $data;

    }

    public function transactionDetail(Transaction $transaction) {
        $data = new TransactionDetailResource($transaction->load('user', 'source'));

        return success('detail page success', $data);
    }
}
