<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function getTransactions(Request $request) {
        $address = $request->input('address');
        $response = [
            'success' => true,
            'message' => 'Transactions imported successfully. Address: ' . $address,
            'payload' => null,
        ];
        return response()->json($response);
    }
}
