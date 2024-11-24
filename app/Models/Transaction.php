<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'block_number',
        'transaction_hash',
        'from_address',
        'to_address',
        'contract_address',
        'token_symbol',
        'token_value',
        'token_decimal',
        'gas',
        'gas_price',
        'gas_used',
        'cumulative_gas_used',
        'wallet_id',
        'time_stamp',
    ];
}
