<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('invoices_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('number', 255);
			$table->date('payment_date')->nullable();
			$table->boolean('status')->default(2);
            $table->integer('invoice_id')->unsigned();
            $table->integer('user_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('section_id')->unsigned();
            $table->string('note', 255)->nullable();
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
        Schema::dropIfExists('invoices_details');
    }
};
