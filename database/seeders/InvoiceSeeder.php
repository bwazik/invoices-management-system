<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('invoices')->delete();

        Invoice::create([
            'number' => 'E-F15-2024W',
            'date' => '2024-04-05',
            'due_date' => '2024-06-05',
            'collection_amount' => '250000',
            'commission_amount' => '15000',
            'discount' => '1500',
            'vat' => '2.5%',
            'vat_value' => '337.50',
            'total' => '13837.50',
            'status' => 3,
            'note' => '-',
            'section_id' => 1,
            'product_id' => 2,
        ]);

        Invoice::create([
            'number' => 'V-F1Z-2024X',
            'date' => '2024-03-06',
            'due_date' => '2030-10-04',
            'collection_amount' => '250000',
            'commission_amount' => '10000',
            'discount' => '0',
            'vat' => '5%',
            'vat_value' => '500.00',
            'total' => '10500.00',
            'status' => 1,
            'note' => 'فاتورة العميل ممدوح',
            'section_id' => 2,
            'product_id' => 4,
        ]);

        Invoice::create([
            'number' => 'Z-A15-2024G',
            'date' => '2024-02-01',
            'due_date' => '2030-10-04',
            'collection_amount' => '650000',
            'commission_amount' => '5000',
            'discount' => '2500',
            'vat' => '7.5%',
            'vat_value' => '187.50',
            'total' => '2687.50',
            'status' => 3,
            'note' => 'فاتورة متاخره',
            'section_id' => 3,
            'product_id' => 6,
        ]);

        Invoice::create([
            'number' => 'X-W15-2024K',
            'date' => '2024-05-05',
            'due_date' => '2030-11-04',
            'collection_amount' => '1000000',
            'commission_amount' => '50000',
            'discount' => '5000',
            'vat' => '10%',
            'vat_value' => '4500.00',
            'total' => '49500.00',
            'status' => 1,
            'note' => '-',
            'section_id' => 4,
            'product_id' => 7,
        ]);

        Invoice::create([
            'number' => 'Q-FX-2024W',
            'date' => '2024-04-05',
            'due_date' => '2030-11-04',
            'collection_amount' => '1500000',
            'commission_amount' => '50000',
            'discount' => '5000',
            'vat' => '10%',
            'vat_value' => '4500.00',
            'total' => '49500.00',
            'status' => 2,
            'note' => '-',
            'section_id' => 5,
            'product_id' => 9,
        ]);
    }
}
