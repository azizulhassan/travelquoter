<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model {

    public function fAddPayment($vPaymentID, $vClientID) {
        try {
            $response = DB::table('tbl_payment')->insert([
                'client_id' => $vClientID,
                'payment_id' => $vPaymentID
            ]);
            if ($response) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    public function fUpdatePayment($vPaymentrID, $vResponse) {
        try {
            $response = DB::table(pmis::TBL_BOOKING_DETAILS)
                    ->where('payment_id', '=', $vPaymentrID)
                    ->update([
                'payment_status' => $vResponse
            ]);
            if ($response) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }
}
