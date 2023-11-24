<?php

namespace App\Http\Controllers\Admin;

use App\Http\Middleware\Admin;
use App\Models\Admin as ModelsAdmin;
use Illuminate\Http\Request;
use App\Models\Ewallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\TransactionFee;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
class EwalletController extends Controller
{
    // public function walletcheckout(Request $request)
    // {
    //     $request->validate([
    //         'amount' => 'required|numeric|min:0',
    //     ]);

    //     // Calculate the transaction fee based on your logic
    //     $transactionFee = 0.05 * $request->amount; // 5% of the order amount

    //     // Deduct the transaction fee from the order total amount
    //     $amountAfterFee = $request->amount - $transactionFee;

    //     // Transfer the transaction fee to the admin's e-wallet
    //     $adminEwallet = Ewallet::firstOrFail();
    //     $adminEwallet->balance += $transactionFee;
    //     $adminEwallet->save();

    //     // Perform the actual payment or checkout process using $amountAfterFee

    //     return redirect('/checkout')->with('success', 'Payment successful. TransactionFee fee deducted and transferred to the admin\'s e-wallet.');
    // }

    public function addFunds(Request $request)
    {
        Session::put('page','wallet');
        return view('admin.wallet.ewallet');
        // $validator = Validator::make($request->all(), [
        //     'amount' => 'required|numeric|min:0.01',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        // }

        // // Logic to add funds to the user's wallet
        // $user = Auth::user()->id;
        // $user->wallet_balance += $request->amount;
        // $user->save();

        // // Log the transaction
        // TransactionFee::create([
        //     'user_id' => $user->id,
        //     'amount' => $request->amount,
        //     'type' => 'credit',
        //     'description' => 'Added funds to wallet',
        // ]);

        // return response()->json(['success' => true, 'message' => 'Funds added successfully']);
    }

    public function transferToAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Logic to transfer funds to the admin's wallet
        $user = Auth::user()->id;
        $admin = Auth::guard('admin')->user()->type;

        if ($user->wallet_balance >= $request->amount) {
            $user->wallet_balance -= $request->amount;
            $admin->wallet_balance += $request->amount;

            $user->save();
            $admin->save();

            // Log the transaction
            TransactionFee::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'debit',
                'description' => 'Transferred funds to admin',
            ]);

            TransactionFee::create([
                'user_id' => $admin->id,
                'amount' => $request->amount,
                'type' => 'credit',
                'description' => 'Received funds from user',
            ]);

            return response()->json(['success' => true, 'message' => 'Transfer successful']);
        } else {
            return response()->json(['success' => false, 'message' => 'Insufficient funds'], 422);
        }
    }

    public function deductCommission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Logic to deduct 5% interest from the user's wallet
        $user = Auth::user()->id;
        $interestAmount = $request->amount * 0.05;

        if ($user->wallet_balance >= $interestAmount) {
            $user->wallet_balance -= $interestAmount;
            $admin = User::where('role', 'admin')->first();
            $admin->wallet_balance += $interestAmount;

            $user->save();
            $admin->save();

            // Log the transaction
            TransactionFee::create([
                'user_id' => $user->id,
                'amount' => $interestAmount,
                'type' => 'debit',
                'description' => 'Deducted interest from wallet',
            ]);

            TransactionFee::create([
                'user_id' => $admin->id,
                'amount' => $interestAmount,
                'type' => 'credit',
                'description' => 'Received interest from user',
            ]);

            return response()->json(['success' => true, 'message' => 'Interest deducted and transferred successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Insufficient funds'], 422);
        }
    }
}
