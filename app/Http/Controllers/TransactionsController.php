<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;

class TransactionsController extends Controller
{
    public function getTransactions(Request $request) {
        $address = $request->input('address');
        $page = $request->input('page');
        $pageSize = $request->input('pageSize');
        $transactionModel = new Transaction();
        $response = $transactionModel->importFromEtherscan($address, $page, $pageSize);
        return response()->json($response);
    }
}
