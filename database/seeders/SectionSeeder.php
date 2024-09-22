<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Section;
use App\Models\User;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sections')->delete();

        $sections = [
            ['en' => 'Qatar National Bank (QNB)', 'ar' => 'بنك قطر الوطني الأهلي'],
            ['en' => 'Commercial International Bank (CIB)', 'ar' => 'البنك التجاري الدولي'],
            ['en' => 'National Bank of Egypt', 'ar' => 'البنك الأهلي المصري'],
            ['en' => 'Credit Agricole Egypt', 'ar' => 'كريدي أجريكول مصر'],
            ['en' => 'Banque du Caire', 'ar' => 'بنك القاهرة'],
        ];

        foreach ($sections as $section) {
            Section::create([
                'name' => $section,
            ]);
        }
    }
}
