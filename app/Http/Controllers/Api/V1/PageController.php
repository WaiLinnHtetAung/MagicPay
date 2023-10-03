<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\UUIDGenerate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\TransferValidate;
use App\Http\Resources\NotificationDetailResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\TransactionDetailResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class PageController extends Controller
{
    public function profile()
    {
        $user = auth()->user()->load('wallet');

        $data = new ProfileResource($user);

        return success('user porfile', $data);
    }

    public function transaction(Request $request)
    {
        $transactions = Transaction::with(['user', 'source'])->orderBy('created_at', 'desc')->where('user_id', auth()->user()->id);

        if ($request->type) {
            $transactions = $transactions->whereType($request->type);
        }

        if ($request->date) {
            //check with only date not time
            $transactions = $transactions->whereDate('created_at', $request->date);
        }

        $transactions = $transactions->paginate(5);

        $data = TransactionResource::collection($transactions)->additional(['result' => 1, 'message' => 'transaction success']);

        return $data;

    }

    public function transactionDetail(Transaction $transaction)
    {
        $data = new TransactionDetailResource($transaction->load('user', 'source'));

        return success('detail page success', $data);
    }

    public function notification()
    {
        $notis = auth()->user()->notifications()->paginate(5);

        return NotificationResource::collection($notis)->additional(['result' => 1, 'message' => 'notis success']);
    }

    public function notificationDetail($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();

        $data = new NotificationDetailResource($notification);

        return success('noti detail success', $data);
    }

    public function verifyAccount(Request $request)
    {
        if ($request->phone) {
            if (auth()->user()->phone == $request->phone) {
                return fail('Invalid number', null);
            }

            $user = User::wherePhone($request->phone)->first();
            if ($user) {
                return success('success', ['name' => $user->name, 'phone' => $user->phone]);
            }

        }

        return fail('Please fill phone number', null);
    }

    public function transferConfirm(TransferValidate $request)
    {
        $user = auth()->user();
        $hash_value = $request->hash_value;
        $str = $request->to_phone . $request->amount . $request->description;
        $hash_value2 = hash_hmac('sha256', $str, 'magicPay123!@#');

        if ($hash_value !== $hash_value2) {
            return fail('Credential not match', null);
        }

        $to_user = User::wherePhone($request->to_phone)->first();
        if (!$to_user) {
            return fail('Phone number is not registered yet', null);
        }

        if ($request->amount > auth()->user()->wallet->amount) {
            return fail('Insufficient Amount', null);
        }

        $data = [
            'from_account' => $user->name,
            'from_phone' => $user->phone,
            'to_account' => $to_user->name,
            'to_phone' => $to_user->phone,
            'amount' => $request->amount,
            'description' => $request->description,
            'hash_value' => $request->hash_value,
        ];

        return success('confirm success', $data);

    }

    public function transferComplete(TransferValidate $request)
    {
        if (!$request->password) {
            return fail('Please fill password', null);
        }

        if (!Hash::check($request->password, auth()->user()->password)) {
            return fail('The password is incorrect', null);
        }

        if ($request->amount < 1000) {
            return fail('The amount must be at least 1000 MMK', null);
        }

        $receiveAccount = User::wherePhone($request->to_phone)->where('phone', '!=', auth()->user()->phone)->first();
        if (!$receiveAccount) {
            return fail('Invalid Phone Number', null);
        }

        $sendAccount = auth()->user();

        if (!$sendAccount->wallet || !$receiveAccount->wallet) {
            return fail('Something wrong. The given data is invalid', null);
        }

        DB::beginTransaction();

        try {
            $sendAccount->wallet()->decrement('amount', $request->amount);
            $receiveAccount->wallet()->increment('amount', $request->amount);

            $ref_no = UUIDGenerate::referNumber();

            //transaction for sender
            $sender = Transaction::create([
                'ref_no' => $ref_no,
                'trx_id' => UUIDGenerate::trxId(),
                'user_id' => $sendAccount->id,
                'type' => 2,
                'amount' => $request->amount,
                'source_id' => $receiveAccount->id,
                'description' => $request->description,
            ]);

            //noti
            $data = [
                'title' => 'E-money Transfered!',
                'message' => "Your wallet transfered <b>" . number_format($request->amount) . "</b> MMK to <b>$receiveAccount->name</b>",
                'sourceable_id' => $sender->id,
                'sourceable_type' => Transaction::class,
                'web_link' => url('/transaction/' . $sender->trx_id),
            ];

            Notification::send([$sendAccount], new GeneralNotification($data));

            //transaction for receiver
            $receiver = Transaction::create([
                'ref_no' => $ref_no,
                'trx_id' => UUIDGenerate::trxId(),
                'user_id' => $receiveAccount->id,
                'type' => 1,
                'amount' => $request->amount,
                'source_id' => $sendAccount->id,
                'description' => $request->description,
            ]);

            //noti
            $data = [
                'title' => 'E-money Received!',
                'message' => "Your wallet received <b>" . number_format($request->amount) . "</b> MMK from <b>$sendAccount->name</b>",
                'sourceable_id' => $receiver->id,
                'sourceable_type' => Transaction::class,
                'web_link' => url('/transaction/' . $receiver->trx_id),
            ];

            Notification::send([$receiveAccount], new GeneralNotification($data));

            DB::commit();
            return success('Transfer Successfully', null);

        } catch (\Exception $error) {
            DB::rollback();
            return fail($error->getMessage(), null);
        }

    }
}
