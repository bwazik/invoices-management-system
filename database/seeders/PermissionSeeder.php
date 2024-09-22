<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        ["en" => "Invoices" , "ar" => "الفواتير"],
        ["en" => "Invoices List" , "ar" => "قائمة الفواتير"],
        ["en" => "Paid Invoices" , "ar" => "الفواتير المدفوعة"],
        ["en" => "Unpaid Invoices" , "ar" => "الفواتير الغير مدفوعة"],
        ["en" => "Partial Paid Invoices" , "ar" => "الفواتير المدفوعة جزئيا"],
        ["en" => "Invoices Archive" , "ar" => "أرشيف الفواتير"],

        ["en" => "Invoice Info" , "ar" => "معلومات الفاتورة"],
        ["en" => "Add Invoice" , "ar" => "إضافة فاتورة"],
        ["en" => "Edit Invoice" , "ar" => "تعديل فاتورة"],
        ["en" => "Delete Invoice" , "ar" => "حذف فاتورة"],
        ["en" => "Archive Invoice" , "ar" => "أرشفة فاتورة"],
        ["en" => "Unarchive Invoice" , "ar" => "إلغاء أرشفة فاتورة"],
        ["en" => "Change Payment Status" , "ar" => "تعديل حالة الدفع"],
        ["en" => "Print Invoice" , "ar" => "طباعة فاتورة"],
        ["en" => "Delete Selected Invoices" , "ar" => "حذف الفواتير المختارة"],
        ["en" => "Archive Selected Invoices" , "ar" => "أرشفة الفواتير المختارة"],
        ["en" => "Unarchive Selected Invoices" , "ar" => "إالغاء أرشفة الفواتير المختارة"],
        ["en" => "Excel Export" , "ar" => "تصدير اكسيل"],
        ["en" => "Add Attachment" , "ar" => "إضافة مرفق"],
        ["en" => "Show Attachment" , "ar" => "عرض مرفق"],
        ["en" => "Download Attachment" , "ar" => "تحميل مرفق"],
        ["en" => "Delete Attachment" , "ar" => "حذف مرفق"],
        ["en" => "Delete All Attachments" , "ar" => "حذف جميع المرفقات"],
        #############################################################################
        ["en" => "Reports" , "ar" => "التقارير"],
        ["en" => "Invoices Reports" , "ar" => "تقارير الفواتير"],
        ["en" => "Customer Reports" , "ar" => "تقارير العملاء"],
        #############################################################################
        ["en" => "Users" , "ar" => "المستخدمين"],
        ["en" => "Users List" , "ar" => "قائمة المستخدمين"],
        ["en" => "Users Permissions" , "ar" => "صلاحيات المستخدمين"],

        ['en' => 'Add User' , 'ar' => 'اضافة مستخدم'],
        ['en' => 'Edit User' , 'ar' => 'تعديل مستخدم'],
        ['en' => 'Delete User' , 'ar' => 'حذف مستخدم'],
        ['en' => 'Delete Selected Users' , 'ar' => 'حذف المستخدمين المختارين'],

        ['en' => 'Add Role' , 'ar' => 'اضافة رتبة'],
        ['en' => 'Edit Role' , 'ar' => 'تعديل رتبة'],
        ['en' => 'Delete Role' , 'ar' => 'حذف رتبة'],
        ['en' => 'Delete Selected Roles' , 'ar' => 'حذف الرتب المختارة'],
        #############################################################################
        ["en" => "Settings" , "ar" => "الإعدادات"],
        ["en" => "Sections" , "ar" => "الأقسام"],
        ["en" => "Products" , "ar" => "المنتجات"],

        ["en" => "Add Section" , "ar" => "إضافة قسم"],
        ["en" => "Edit Section" , "ar" => "تعديل قسم"],
        ["en" => "Delete Section" , "ar" => "حذف قسم"],
        ["en" => "Delete Selected Sections" , "ar" => "حذف الأقسام المختارة"],

        ["en" => "Add Product" , "ar" => "إضافة منتج"],
        ["en" => "Edit Product" , "ar" => "تعديل منتج"],
        ["en" => "Delete Product" , "ar" => "حذف منتج"],
        ["en" => "Delete Selected Products" , "ar" => "حذف المنتجات المختارة"],
        #############################################################################
    ];

    public function run(): void
    {
        foreach ($this -> permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
