<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('block_number');
            $table->string('transaction_hash')->unique();
            $table->string('from_address');
            $table->string('to_address');
            $table->string('contract_address')->nullable();
            $table->string('token_symbol')->nullable();
            $table->decimal('token_value', 50, 0)->nullable();
            $table->unsignedInteger('token_decimal')->default(18);
            $table->unsignedBigInteger('gas');
            $table->unsignedBigInteger('gas_price');
            $table->unsignedBigInteger('gas_used');
            $table->unsignedBigInteger('cumulative_gas_used');
            $table->unsignedBigInteger('wallet_id');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->timestamp('time_stamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
