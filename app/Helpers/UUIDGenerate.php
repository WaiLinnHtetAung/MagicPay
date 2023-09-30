<?php

namespace App\Helpers;
use App\Models\Wallet;
use App\Models\Transaction;

class UUIDGenerate{
    public static function accountNumber() {
        $number = mt_rand(1000000000000000, 9999999999999999);

        if(Wallet::whereAccountNumber($number)->exists()) {
            self::accountNumber();  //call this function again
        }
        return $number;
    }

    public static function referNumber() {
        $number = mt_rand(1000000000000000, 9999999999999999);

        if(Transaction::whereRefNo($number)->exists()) {
            self::referNumber();  //call this function again
        }
        return $number;
    }

    public static function trxId() {
        $number = mt_rand(1000000000000000, 9999999999999999);

        if(Transaction::whereTrxId($number)->exists()) {
            self::trxId();  //call this function again
        }
        return $number;
    }
}

?>
