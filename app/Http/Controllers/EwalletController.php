<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ewallet;

class EwalletController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        // Calculate the transaction fee based on your logic
        $transactionFee = 0.05 * $request->amount; // 5% of the order amount

        // Deduct the transaction fee from the order total amount
        $amountAfterFee = $request->amount - $transactionFee;

        // Transfer the transaction fee to the admin's e-wallet
        $adminEwallet = Ewallet::firstOrFail();
        $adminEwallet->balance += $transactionFee;
        $adminEwallet->save();

        // Perform the actual payment or checkout process using $amountAfterFee

        return redirect('/checkout')->with('success', 'Payment successful. Transaction fee deducted and transferred to the admin\'s e-wallet.');
    }
}
