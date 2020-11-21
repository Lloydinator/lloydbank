<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTxnparticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txnparticipants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_user_id')->nullable();
            $table->bigInteger('to_user_id')->nullable();
            $table->integer('transaction_id')->nullable()->unique()->unsigned();
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
        Schema::dropIfExists('txnparticipants');
    }
}
