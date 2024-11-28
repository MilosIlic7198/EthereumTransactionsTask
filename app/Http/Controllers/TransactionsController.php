<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;

class TransactionsController extends Controller
{
    public function getTransactions(Request $request) {
        $address = $request->input('address');
        $transactionModel = new Transaction();
        $response = $transactionModel->importFromEtherscan($address);
        return response()->json($response);
    }
}
