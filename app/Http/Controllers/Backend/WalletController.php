<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function index() {
        return view('admin.wallet.index');
    }

    public function ssd() {
        $wallets = Wallet::with('user');

        return Datatables::of($wallets)
            ->editColumn('account_person', function($each) {
                $user = $each->user;
                if($user) {
                    return "<p><b>Name</b>: $user->name</p><p><b>Email</b>: $user->email</p><p><b>Phone</b>: $user->phone</p>";
                }

                return '-';
            })
            ->editColumn('amount', function($each) {
                return number_format($each->amount, 2);
            })
            ->editColumn('created_at', function($each) {
                return $each->created_at->format('d-m-Y H:i:s');
            })
            ->editColumn('updated_at', function($each) {
                return $each->updated_at->format('d-m-Y H:i:s');
            })
            ->rawColumns(['account_person'])
            ->make(true);
    }
}
