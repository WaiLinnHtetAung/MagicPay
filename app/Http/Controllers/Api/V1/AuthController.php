<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        DB::beginTransaction();

        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'ip' => $request->ip(),
                'user_agent' => $request->server('HTTP_USER_AGENT'),
                'login_at' => date('Y-m-d H:i:s')
            ]);

            Wallet::firstOrCreate(
                [
                    'user_id' => $user->id   //conditional statement
                ],
                [
                    'account_number'    => UUIDGenerate::accountNumber(),
                    'amount'            => 5000,
                ]
            );

            DB::commit();

            $token = $user->createToken('Magic Pay')->accessToken;

            return success('Successfully registered', ['token' => $token]);
        }catch(\Exception $err) {
            return fail($err->getMessage(), []);
        }
    }

    public function login(Request $request) {

        $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);

        if(Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = auth()->user();
            $token = $user->createToken('Magic Pay')->accessToken;

            return success('Successfully login', ['token' => $token, 'user' => $user]);
        }

        return fail("The credential doesn't match our records. Try again!", []);
    }

    public function logout() {
        auth()->user()->token()->revoke();
        return success('Success logout', null);
    }
}
