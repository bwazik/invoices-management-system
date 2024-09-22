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
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        #######################################################################
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        #######################################################################
        Schema::table('invoices_details', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('invoices_details', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('invoices_details', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('invoices_details', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        #######################################################################
        Schema::table('invoices_attachments', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('invoices_attachments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_section_id_foreign');
        });
        #######################################################################
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_section_id_foreign');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_product_id_foreign');
        });
        #######################################################################
        Schema::table('invoices_details', function (Blueprint $table) {
            $table->dropForeign('invoices_details_invoice_id_foreign');
        });
        Schema::table('invoices_details', function (Blueprint $table) {
            $table->dropForeign('invoices_details_user_id_foreign');
        });
        Schema::table('invoices_details', function (Blueprint $table) {
            $table->dropForeign('invoices_details_product_id_foreign');
        });
        Schema::table('invoices_details', function (Blueprint $table) {
            $table->dropForeign('invoices_details_section_id_foreign');
        });
        #######################################################################
        Schema::table('invoices_attachments', function (Blueprint $table) {
            $table->dropForeign('invoices_attachments_invoice_id_foreign');
        });
        Schema::table('invoices_attachments', function (Blueprint $table) {
            $table->dropForeign('invoices_attachments_invoice_id_foreign');
        });
    }
};
