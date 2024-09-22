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
		Schema::create('invoices_attachments', function(Blueprint $table) {
			$table->increments('id');
			$table->string('number', 255);
			$table->string('file', 255);
            $table->integer('invoice_id')->unsigned();
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('invoices');
    }
};
