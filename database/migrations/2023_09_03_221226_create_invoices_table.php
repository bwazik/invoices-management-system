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
		Schema::create('invoices', function(Blueprint $table) {
			$table->increments('id');
			$table->string('number', 255);
			$table->date('date');
			$table->date('due_date');
            $table->decimal('collection_amount', 12, 2);
			$table->decimal('commission_amount', 12, 2);
			$table->decimal('discount', 12, 2);
			$table->string('vat', 255);
			$table->decimal('vat_value', 12, 2);
			$table->decimal('total', 12, 2);
			$table->boolean('status')->default(2);
			$table->string('note', 255)->nullable();
			$table->integer('product_id')->unsigned();
			$table->integer('section_id')->unsigned();
            $table->date('payment_date')->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
