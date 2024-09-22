<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\InvoiceDetail;

class InvoiceDetailSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('invoices_details')->delete();

        InvoiceDetail::create([
            'number' => 'الفاتورة الاولي',
            'status' => 2,
            'invoice_id' => 1,
            'user_id' => 1,
            'section_id' => 1,
            'product_id' => 2,
        ]);

        InvoiceDetail::create([
            'number' => 'الفاتورة الثانيه',
            'status' => 2,
            'invoice_id' => 2,
            'user_id' => 1,
            'section_id' => 2,
            'product_id' => 4,
        ]);

        InvoiceDetail::create([
            'number' => 'الفاتورة الثالثه',
            'status' => 2,
            'invoice_id' => 3,
            'user_id' => 1,
            'section_id' => 3,
            'product_id' => 6,
        ]);

        InvoiceDetail::create([
            'number' => 'الفاتورة الرابعة',
            'status' => 2,
            'invoice_id' => 4,
            'user_id' => 1,
            'section_id' => 4,
            'product_id' => 7,
        ]);

        InvoiceDetail::create([
            'number' => 'الفاتورة الخامسه',
            'status' => 2,
            'invoice_id' => 5,
            'user_id' => 1,
            'section_id' => 5,
            'product_id' => 9,
        ]);
    }

}
