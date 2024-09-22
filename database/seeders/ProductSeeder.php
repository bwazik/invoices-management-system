<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Section;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->delete();

        $firstSections = [
            ['en' => 'Credit Card (CC)', 'ar' => 'البطاقة الإئتمانية'],
            ['en' => 'Cash and check deposits', 'ar' => 'الودائع النقدية والشيكات'],
        ];

        foreach ($firstSections as $section) {
            Product::create([
                'name' => $section,
                'section_id' => Section::first()->id,
            ]);
        }

        $secondSections = [
            ['en' => 'Post Dated Checks (PDC)', 'ar' => 'إدارة الشيكات المؤجلة'],
            ['en' => 'Mortgage financing', 'ar' => 'التمويل العقاري'],
        ];

        foreach ($secondSections as $section) {
            Product::create([
                'name' => $section,
                'section_id' => Section::skip(1)->first()->id
            ]);
        }

        $thirdSections = [
            ['en' => 'Depit Cards', 'ar' => 'خدمات الخصم المباشر'],
            ['en' => 'Financial collection', 'ar' => 'التحصيل المالي'],
        ];

        foreach ($thirdSections as $section) {
            Product::create([
                'name' => $section,
                'section_id' => Section::skip(2)->first()->id
            ]);
        }

        $fourthSections = [
            ['en' => 'Incoming transfers', 'ar' => 'التحويلات الواردة'],
            ['en' => 'Personal Loans', 'ar' => 'القروض الشخصية'],
        ];

        foreach ($fourthSections as $section) {
            Product::create([
                'name' => $section,
                'section_id' => Section::skip(3)->first()->id
            ]);
        }

        $fifthSections = [
            ['en' => 'Automated teller machine', 'ar' => 'ماكينة الإيداع النقدي'],
            ['en' => 'Secure money transfer services', 'ar' => 'خدمة نقل الأموال الآمن'],
        ];

        foreach ($fifthSections as $section) {
            Product::create([
                'name' => $section,
                'section_id' => Section::skip(4)->first()->id
            ]);
        }
    }
}
