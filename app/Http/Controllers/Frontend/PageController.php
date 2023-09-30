<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\GeneralNotification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Frontend\UpdatePassword;
use App\Http\Requests\Frontend\TransferValidate;

class PageController extends Controller
{
    public function home() {
        return view('frontend.home');
    }

    public function profile() {
        return view('frontend.profile');
    }

    public function updatePassword() {
        return view('frontend.update_password');
    }

    public function updatePasswordStore(UpdatePassword $request) {
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user = auth()->user();

        if(Hash::check($old_password, $user->password)) {
            $user->update(['password' => Hash::make($new_password)]);

            $data = [
                'title' => 'Changed Password',
                'message' => 'Your account is successfully changed',
                'sourceable_id' => $user->id,
                'sourceable_type' => User::class,
                'web_link'  => url('profile')
            ];

            Notification::send([$user], new GeneralNotification ($data));

            return redirect()->route('profile')->with('success', 'Password Updated Successfully');
        }

        return back()->with('fail', 'The old password is not correct');
    }

    public function wallet() {
        return view('frontend.wallet');
    }

    public function transfer() {
        return view('frontend.transfer');
    }

    public function transferConfirm(TransferValidate $request) {

        $to_user = User::wherePhone($request->to_phone)->first();
        if(!$to_user) {
            return back()->withErrors(['to_phone' => 'Phone number is not registered yet'])->withInput();
        }

        if($request->amount > auth()->user()->wallet->amount) {
            return back()->withErrors(['amount' => 'Insufficient Amount'])->withInput();
        }


        $transfer_data = $request;
        return view('frontend.transfer_confirm', compact('transfer_data', 'to_user'));
    }

    public function verifyAccount(Request $request) {
        $user = User::wherePhone($request->phone)->where('phone', '!=', auth()->user()->phone)->first();

        if($user) {
            return response()->json([
                'status' => true,
                'data' => $user
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid number'
        ]);
    }

    public function transferComplete(TransferValidate $request) {
        if($request->amount < 1000 ) {
            return back()->withErrors(['amount' => 'The amount must be at least 1000 MMK.'])->withInput();
        }

        $receiveAccount = User::wherePhone($request->to_phone)->where('phone', '!=', auth()->user()->phone)->first();
        if(!$receiveAccount) {
            return back()->withErrors(['to_phone' => 'Invalid Phone Number'])->withInput();
        }

        $sendAccount = auth()->user();

        if(!$sendAccount->wallet || !$receiveAccount->wallet) {
            return back()->withErrors(['fail' => 'Something wrong. The given data is invalid'])->withInput();
        }

        DB::beginTransaction();

        try {
            $sendAccount->wallet()->decrement('amount', $request->amount);
            $receiveAccount->wallet()->increment('amount', $request->amount);

            $ref_no = UUIDGenerate::referNumber();

            //transaction for sender
            $sender = Transaction::create([
                    'ref_no' => $ref_no ,
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
                'message' => "Your wallet transfered <b>".number_format($request->amount)."</b> MMK to <b>$receiveAccount->name</b>",
                'sourceable_id' => $sender->id,
                'sourceable_type' => Transaction::class,
                'web_link'  => url('/transaction/'.$sender->trx_id)
            ];

            Notification::send([$sendAccount], new GeneralNotification ($data));

            //transaction for receiver
            $receiver = Transaction::create([
                    'ref_no' => $ref_no ,
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
                'message' => "Your wallet received <b>".number_format($request->amount)."</b> MMK from <b>$sendAccount->name</b>",
                'sourceable_id' => $receiver->id,
                'sourceable_type' => Transaction::class,
                'web_link'  => url('/transaction/'.$receiver->trx_id)
            ];

            Notification::send([$receiveAccount], new GeneralNotification ($data));

            DB::commit();

        } catch(\Exception $error) {
            DB::rollback();
            return back()->withErrors(['fail' => 'Something wrong. '. $error->getMessage()])->withInput();
        }

        return redirect("/transaction/$sender->trx_id")->with('success', 'Transfer Successfully');
    }

    // Receive QR
    public function receiveQR() {
        return view('frontend.receive_qr');
    }

    public function passwordCheck(Request $request) {
        if(!$request->password) {
            return response()->json([
                'status' => false,
                'message' => 'Please fill your password',
            ]);
        }
        if(Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'status' => true,
                'message' => 'The password is correct',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'The password is not correct',
        ]);
    }

    public function downloadQR() {
        return response()->streamDownload(
            function () {
                echo QrCode::size(200)
                    ->format('png')
                    ->merge(public_path('images/logo.png'), 0.3, true)
                    ->generate(auth()->user()->phone);
            },
            'qr-code.png',
            [
                'Content-Type' => 'image/png',
            ]
        );
    }


    //Scan and Pay
    public function scanQR() {
        return view('frontend.scan_qr');
    }

    public function scanAndPayForm(Request $request) {
        $receive_user = User::wherePhone($request->scanned_phone)->first();

        if(!$receive_user) {
            return back()->with('fail', 'Qr code is invalid');
        }

        $receive_phone = $request->scanned_phone;

        return view('frontend.transfer', compact('receive_phone'));

    }


    // Transaction
    public function transaction(Request $request) {
        $transactions = Transaction::with(['user', 'source'])->orderBy('created_at', 'desc')->where('user_id', auth()->user()->id);

        if($request->type) {
            $transactions = $transactions->whereType($request->type);
        }

        if($request->date) {
            //check with only date not time
            $transactions = $transactions->whereDate('created_at', $request->date);
        }

        $transactions = $transactions->get();

        return view('frontend.transaction', compact('transactions'));
    }

    public function transactionDetail($trx_id) {
        $transaction = Transaction::where('user_id', auth()->user()->id)->where('trx_id', $trx_id)->first();

        return view('frontend.transaction_detail', compact('transaction'));
    }

    public function logout() {
        Auth::guard('web')->logout();

        return 'success';
    }
}
